<?php
/**
 * Diagnostic Script: Debug Database Connection
 */
require_once __DIR__ . '/api/config.php';

header('Content-Type: text/plain');

echo "--- ASPORD DATABASE DIAGNOSTICS ---\n\n";

echo "Configuration:\n";
echo "Host: " . DB_HOST . "\n";
echo "Database: " . DB_NAME . "\n";
echo "User: " . DB_USER . "\n";
echo "Pass: " . (empty(DB_PASS) ? "(empty)" : "********") . "\n\n";

try {
    echo "1. Attempting connection to MySQL server (no DB specified)...\n";
    $pdo_base = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS);
    echo "✅ Successfully connected to MySQL server!\n\n";

    echo "2. Listing available databases:\n";
    $stmt = $pdo_base->query("SHOW DATABASES");
    $databases = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $found_qrify = false;
    $found_aspord = false;

    foreach ($databases as $db) {
        if ($db === 'qrify_db') $found_qrify = true;
        if ($db === 'aspord_db') $found_aspord = true;
        echo "- $db\n";
    }
    echo "\n";

    if ($found_aspord) {
        echo "✅ 'aspord_db' EXISTS.\n";
    } else if ($found_qrify) {
        echo "❌ 'aspord_db' MISSING, but 'qrify_db' FOUND.\n";
        echo "TIP: You should rename 'qrify_db' to 'aspord_db' in PHPMyAdmin.\n";
    } else {
        echo "❌ Both 'aspord_db' and 'qrify_db' are MISSING.\n";
        echo "TIP: Please run 'database_setup.sql' in PHPMyAdmin.\n";
    }

    echo "\n3. Attempting connection to specific database '" . DB_NAME . "'...\n";
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        echo "✅ Successfully connected to '" . DB_NAME . "'!\n\n";
        
        echo "4. Checking 'menu_items' table...\n";
        $stmt = $pdo->query("SHOW TABLES LIKE 'menu_items'");
        if ($stmt->fetch()) {
            $count = $pdo->query("SELECT COUNT(*) FROM menu_items")->fetchColumn();
            echo "✅ 'menu_items' table exists with $count items.\n";
        } else {
            echo "❌ 'menu_items' table MISSING in '" . DB_NAME . "'.\n";
        }

    } catch (PDOException $e) {
        echo "❌ FAILED to connect to '" . DB_NAME . "': " . $e->getMessage() . "\n";
    }

} catch (PDOException $e) {
    echo "❌ FAILED to connect to MySQL server: " . $e->getMessage() . "\n";
}
