<?php
require_once __DIR__ . '/api/db.php';
try {
    $db = getDB();
    
    // Fix user_sessions
    echo "Syncing user_sessions...\n";
    $cols = $db->query("SHOW COLUMNS FROM user_sessions")->fetchAll(PDO::FETCH_COLUMN);
    
    if (!in_array('email', $cols)) {
        $db->exec("ALTER TABLE user_sessions ADD COLUMN email VARCHAR(255) NULL AFTER mobile");
    }
    
    // Ensure mobile is nullable everywhere
    $db->exec("ALTER TABLE user_sessions MODIFY COLUMN mobile VARCHAR(15) NULL");
    $db->exec("ALTER TABLE users MODIFY COLUMN mobile VARCHAR(15) NULL");
    $db->exec("ALTER TABLE otp_requests MODIFY COLUMN mobile VARCHAR(15) NULL");

    // Ensure email is in otp_requests
    $cols_otp = $db->query("SHOW COLUMNS FROM otp_requests")->fetchAll(PDO::FETCH_COLUMN);
    if (!in_array('email', $cols_otp)) {
        $db->exec("ALTER TABLE otp_requests ADD COLUMN email VARCHAR(255) NULL AFTER mobile");
    }

    echo "Sync completed successfully.\n";
} catch (Exception $e) {
    echo "Sync failed: " . $e->getMessage() . "\n";
}
