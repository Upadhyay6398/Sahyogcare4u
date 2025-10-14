<?php
// Debug test file - Test if AJAX endpoint is working
// Access: ajax/test-upload-debug.php

ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "=== UPLOAD DEBUG TEST ===\n\n";

// Test 1: PHP Version
echo "PHP Version: " . phpversion() . "\n";

// Test 2: Session
session_start();
echo "Session Started: " . (session_id() ? "YES" : "NO") . "\n";
echo "Admin User ID: " . (isset($_SESSION['ADMIN_USER_ID']) ? $_SESSION['ADMIN_USER_ID'] : "NOT SET") . "\n\n";

// Test 3: Config
echo "Testing config.php...\n";
if (file_exists("../config.php")) {
    require("../config.php");
    echo "✅ config.php loaded\n";
    echo "Database: " . DB . "\n";
    echo "DB Object: " . (isset($DB) ? "YES" : "NO") . "\n";
} else {
    echo "❌ config.php NOT FOUND\n";
}

// Test 4: JSON Output
echo "\n=== JSON TEST ===\n";
header('Content-Type: application/json');
$testResponse = [
    'success' => true,
    'message' => 'Test successful!',
    'timestamp' => date('Y-m-d H:i:s'),
    'session_check' => isset($_SESSION['ADMIN_USER_ID']),
    'db_check' => isset($DB)
];

echo json_encode($testResponse, JSON_PRETTY_PRINT);
?>

