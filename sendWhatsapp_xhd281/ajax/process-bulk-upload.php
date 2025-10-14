<?php
// Start output buffering to catch any unexpected output
ob_start();

// Disable error display to prevent breaking JSON
ini_set('display_errors', 0);
error_reporting(0);

require("../config.php");


if (!isset($_SESSION['ADMIN_USER_ID'])) {
    ob_clean();
    echo json_encode([
        'success' => false,
        'message' => 'Please login first. Redirecting...',
        'total' => 0,
        'uploaded' => 0,
        'failed' => 0,
        'errors' => []
    ]);
    exit;
}

header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => '',
    'total' => 0,
    'uploaded' => 0,
    'failed' => 0,
    'errors' => []
];

try {
    // Check if file was uploaded
    if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
        $response['message'] = 'File upload failed. Please try again.';
        echo json_encode($response);
        exit;
    }
    
    $file = $_FILES['csv_file'];
    $fileName = $file['name'];
    $fileTmp = $file['tmp_name'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    // Process based on file type
    $data = [];
    
    if ($fileExt === 'csv') {
        // Process CSV file
        if (($handle = fopen($fileTmp, 'r')) !== FALSE) {
            // Read first line and remove BOM if present
            $firstLine = fgets($handle);
            
            // Remove UTF-8 BOM (Byte Order Mark) if present
            $bom = pack('H*','EFBBBF');
            $firstLine = preg_replace("/^$bom/", '', $firstLine);
            
            // Parse first line as CSV
            $headers = str_getcsv($firstLine);
            
            // Normalize headers (remove spaces, BOM, convert to lowercase)
            $headers = array_map(function($h) {
                // Remove BOM and other special characters
                $h = str_replace(["\xEF\xBB\xBF", "\x00", "\r", "\n"], '', $h);
                return strtolower(trim($h));
            }, $headers);
            
            // Find column indices (flexible matching)
            $nameCol = array_search('name', $headers);
            $mobileCol = array_search('mobile', $headers);
            $amountCol = array_search('amount', $headers);
            
            // Try alternative names if not found
            if ($nameCol === false) {
                $nameCol = array_search('donorname', $headers);
                if ($nameCol === false) $nameCol = array_search('donor', $headers);
            }
            if ($mobileCol === false) {
                $mobileCol = array_search('phone', $headers);
                if ($mobileCol === false) $mobileCol = array_search('mobilenumber', $headers);
                if ($mobileCol === false) $mobileCol = array_search('contact', $headers);
            }
            if ($amountCol === false) {
                $amountCol = array_search('donation', $headers);
                if ($amountCol === false) $amountCol = array_search('price', $headers);
            }
            
            if ($nameCol === false || $mobileCol === false || $amountCol === false) {
                $response['message'] = 'CSV file must have "Name", "Mobile", and "Amount" columns. Found columns: ' . implode(', ', $headers);
                echo json_encode($response);
                exit;
            }
            
            // Read data rows
            while (($row = fgetcsv($handle)) !== FALSE) {
                if (count($row) >= 3) {
                    $data[] = [
                        'name' => isset($row[$nameCol]) ? trim($row[$nameCol]) : '',
                        'mobile' => isset($row[$mobileCol]) ? trim($row[$mobileCol]) : '',
                        'amount' => isset($row[$amountCol]) ? trim($row[$amountCol]) : ''
                    ];
                }
            }
            fclose($handle);
        }
    } elseif ($fileExt === 'xlsx' || $fileExt === 'xls') {
        // Process Excel file using a simple XML parser for xlsx
        if ($fileExt === 'xlsx') {
            // Check if SimpleXLSX library exists
            if (file_exists('../lib/SimpleXLSX.php')) {
                require_once('../lib/SimpleXLSX.php');
                
                if ($xlsx = SimpleXLSX::parse($fileTmp)) {
                    $rows = $xlsx->rows();
                    
                    if (count($rows) > 0) {
                        $headers = array_map(function($h) {
                            return strtolower(trim(str_replace([' ', '\t', '\r', '\n'], '', $h)));
                        }, $rows[0]);
                        
                        // Find column indices (flexible matching)
                        $nameCol = array_search('name', $headers);
                        $mobileCol = array_search('mobile', $headers);
                        $amountCol = array_search('amount', $headers);
                        
                        // Try alternative names if not found
                        if ($nameCol === false) {
                            $nameCol = array_search('donorname', $headers);
                            if ($nameCol === false) $nameCol = array_search('donor', $headers);
                        }
                        if ($mobileCol === false) {
                            $mobileCol = array_search('phone', $headers);
                            if ($mobileCol === false) $mobileCol = array_search('mobilenumber', $headers);
                            if ($mobileCol === false) $mobileCol = array_search('contact', $headers);
                        }
                        if ($amountCol === false) {
                            $amountCol = array_search('donation', $headers);
                            if ($amountCol === false) $amountCol = array_search('price', $headers);
                        }
                        
                        if ($nameCol === false || $mobileCol === false || $amountCol === false) {
                            $response['message'] = 'Excel file must have "Name", "Mobile", and "Amount" columns. Found columns: ' . implode(', ', $headers);
                            echo json_encode($response);
                            exit;
                        }
                        
                        // Read data rows (skip header)
                        for ($i = 1; $i < count($rows); $i++) {
                            $row = $rows[$i];
                            
                            // Skip completely empty rows
                            if (empty($row) || count(array_filter($row)) === 0) {
                                continue;
                            }
                            
                            // Extract values from correct columns
                            $name = isset($row[$nameCol]) ? trim($row[$nameCol]) : '';
                            $mobile = isset($row[$mobileCol]) ? trim($row[$mobileCol]) : '';
                            $amount = isset($row[$amountCol]) ? trim($row[$amountCol]) : '';
                            
                            // Skip row if all values are empty
                            if (empty($name) && empty($mobile) && empty($amount)) {
                                continue;
                            }
                            
                            $data[] = [
                                'name' => $name,
                                'mobile' => $mobile,
                                'amount' => $amount
                            ];
                        }
                    }
                } else {
                    $response['message'] = 'Error parsing Excel file: ' . SimpleXLSX::parseError();
                    echo json_encode($response);
                    exit;
                }
            } else {
                $response['message'] = 'Excel support library not found. Please use CSV format or contact admin.';
                echo json_encode($response);
                exit;
            }
        } else {
            $response['message'] = 'XLS format not supported. Please convert to XLSX or use CSV format.';
            echo json_encode($response);
            exit;
        }
    } else {
        $response['message'] = 'Invalid file format. Please upload CSV or XLSX file.';
        echo json_encode($response);
        exit;
    }
    
    // Validate and insert data
    $response['total'] = count($data);
    
    if (count($data) === 0) {
        $response['message'] = 'No valid data found in the file.';
        echo json_encode($response);
        exit;
    }
    
    foreach ($data as $index => $row) {
        $rowNum = $index + 2; // +2 because index starts at 0 and we skip header
        
        // Validate name
        if (empty($row['name'])) {
            $response['errors'][] = "Row $rowNum: Name is empty";
            $response['failed']++;
            continue;
        }
        
        // Clean mobile number - only remove spaces and special chars
        $mobile = preg_replace('/[^0-9]/', '', $row['mobile']);
        
        // Validate mobile number length (minimum 10 digits)
        if (strlen($mobile) < 10) {
            $response['errors'][] = "Row $rowNum: Mobile number too short - " . $row['mobile'];
            $response['failed']++;
            continue;
        }
        
        // Use mobile number exactly as provided (no auto 91 addition)
        // Mobile will be saved and sent exactly as entered in Excel
        
        // Validate amount
        if (!is_numeric($row['amount']) || floatval($row['amount']) <= 0) {
            $response['errors'][] = "Row $rowNum: Invalid amount - " . $row['amount'];
            $response['failed']++;
            continue;
        }
        
        // Insert into database
        try {
            $insertData = [
                'name' => $row['name'],
                'mobile' => $mobile,
                'amount' => floatval($row['amount']),
                'status' => 'pending',
                'sent_by' => $_SESSION['ADMIN_USER_ID'] ?? null,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $DB->insert('whatsapp_logs', $insertData);
            $response['uploaded']++;
            
        } catch (Exception $e) {
            $response['errors'][] = "Row $rowNum: Database error - " . $e->getMessage();
            $response['failed']++;
        }
    }
    
    $response['success'] = true;
    $response['message'] = 'File processed successfully!';
    
    // Limit errors to first 10
    if (count($response['errors']) > 10) {
        $remaining = count($response['errors']) - 10;
        $response['errors'] = array_slice($response['errors'], 0, 10);
        $response['errors'][] = "... and $remaining more errors";
    }
    
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

// Clean output buffer to prevent any extra output
ob_clean();

// Send JSON response
echo json_encode($response);
exit;
