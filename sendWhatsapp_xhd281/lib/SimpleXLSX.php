<?php
/**
 * SimpleXLSX - Simple XLSX Parser
 * Lightweight parser for reading basic XLSX files
 */
class SimpleXLSX {
    private $worksheets = [];
    private static $error = '';
    
    public static function parse($filename) {
        self::$error = '';
        
        if (!file_exists($filename)) {
            self::$error = 'File not found';
            return false;
        }
        
        $zip = new ZipArchive();
        if ($zip->open($filename) !== true) {
            self::$error = 'Unable to open XLSX file';
            return false;
        }
        
        try {
            $xlsx = new self();
            
            // Read shared strings
            $sharedStrings = [];
            if ($zip->locateName('xl/sharedStrings.xml') !== false) {
                $sharedStringsXml = $zip->getFromName('xl/sharedStrings.xml');
                if ($sharedStringsXml) {
                    $xml = simplexml_load_string($sharedStringsXml);
                    if ($xml) {
                        foreach ($xml->si as $si) {
                            $sharedStrings[] = (string)$si->t;
                        }
                    }
                }
            }
            
            // Read worksheet data
            $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
            if (!$sheetXml) {
                self::$error = 'Unable to read worksheet data';
                $zip->close();
                return false;
            }
            
            $xml = simplexml_load_string($sheetXml);
            if (!$xml) {
                self::$error = 'Unable to parse worksheet XML';
                $zip->close();
                return false;
            }
            
            $rows = [];
            $currentRow = [];
            $currentRowNum = 0;
            
            foreach ($xml->sheetData->row as $row) {
                $rowNum = (int)$row['r'];
                $currentRow = [];
                
                foreach ($row->c as $cell) {
                    $cellRef = (string)$cell['r'];
                    $cellType = (string)$cell['t'];
                    
                    // Get column index from cell reference (e.g., A1 -> 0, B1 -> 1)
                    preg_match('/([A-Z]+)/', $cellRef, $matches);
                    $col = self::columnIndexFromString($matches[1]);
                    
                    // Fill empty columns
                    while (count($currentRow) < $col) {
                        $currentRow[] = '';
                    }
                    
                    // Get cell value
                    if ($cellType == 's') {
                        // Shared string
                        $stringIndex = (int)$cell->v;
                        $value = isset($sharedStrings[$stringIndex]) ? $sharedStrings[$stringIndex] : '';
                    } else {
                        // Direct value
                        $value = (string)$cell->v;
                    }
                    
                    $currentRow[] = $value;
                }
                
                $rows[] = $currentRow;
            }
            
            $xlsx->worksheets = $rows;
            $zip->close();
            
            return $xlsx;
            
        } catch (Exception $e) {
            self::$error = $e->getMessage();
            $zip->close();
            return false;
        }
    }
    
    public function rows() {
        return $this->worksheets;
    }
    
    public static function parseError() {
        return self::$error;
    }
    
    private static function columnIndexFromString($column) {
        $column = strtoupper($column);
        $length = strlen($column);
        $index = 0;
        
        for ($i = 0; $i < $length; $i++) {
            $index = $index * 26 + (ord($column[$i]) - ord('A') + 1);
        }
        
        return $index - 1; // 0-based index
    }
}
?>


