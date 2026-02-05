<?php
require_once __DIR__ . '/api/db.php';
try {
    $db = getDB();
    
    $tables = [
        'users' => "ALTER TABLE users ADD COLUMN email VARCHAR(255) UNIQUE AFTER name",
        'user_sessions' => "ALTER TABLE user_sessions ADD COLUMN email VARCHAR(255) NULL AFTER user_id",
        'otp_requests' => "ALTER TABLE otp_requests ADD COLUMN email VARCHAR(255) NULL AFTER mobile"
    ];

    foreach ($tables as $table => $sql) {
        $q = $db->query("SHOW COLUMNS FROM $table");
        $cols = []; while($r = $q->fetch()) $cols[] = $r['Field'];
        
        if (!in_array('email', $cols)) {
            echo "Adding email to $table...\n";
            $db->exec($sql);
        }
        
        if (in_array('mobile', $cols)) {
            echo "Making mobile nullable in $table...\n";
            $db->exec("ALTER TABLE $table MODIFY COLUMN mobile VARCHAR(15) NULL");
        }
    }
    
    echo "Sync Successful.\n";
} catch (Exception $e) {
    echo "Sync Remark: " . $e->getMessage() . " (It might already exist)\n";
}
