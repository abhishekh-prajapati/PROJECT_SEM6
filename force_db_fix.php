<?php
/**
 * FORCE DATABASE SYNC - Fixing "Unknown column 'email'"
 */
require_once __DIR__ . '/api/db.php';

try {
    $db = getDB();
    echo "Starting Force Sync...\n";

    // 1. Fix 'users' table
    $stmt = $db->query("SHOW COLUMNS FROM users LIKE 'email'");
    if (!$stmt->fetch()) {
        echo "- Adding 'email' to users...\n";
        $db->exec("ALTER TABLE users ADD COLUMN email VARCHAR(255) NULL AFTER name");
        $db->exec("ALTER TABLE users ADD UNIQUE KEY (email)");
    }
    $db->exec("ALTER TABLE users MODIFY COLUMN mobile VARCHAR(15) NULL");

    // 2. Fix 'otp_requests' table
    $stmt = $db->query("SHOW COLUMNS FROM otp_requests LIKE 'email'");
    if (!$stmt->fetch()) {
        echo "- Adding 'email' to otp_requests...\n";
        $db->exec("ALTER TABLE otp_requests ADD COLUMN email VARCHAR(255) NULL AFTER mobile");
    }
    $db->exec("ALTER TABLE otp_requests MODIFY COLUMN mobile VARCHAR(15) NULL");

    // 3. Fix 'user_sessions' table
    $stmt = $db->query("SHOW COLUMNS FROM user_sessions LIKE 'email'");
    if (!$stmt->fetch()) {
        echo "- Adding 'email' to user_sessions...\n";
        $db->exec("ALTER TABLE user_sessions ADD COLUMN email VARCHAR(255) NULL AFTER user_id");
    }
    $db->exec("ALTER TABLE user_sessions MODIFY COLUMN mobile VARCHAR(15) NULL");

    echo "✅ Database is now in sync!\n";

} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}
