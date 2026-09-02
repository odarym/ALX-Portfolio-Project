<?php
/**
 * scripts/init_db.php
 * Automated database provisioning & engine startup script for OdaKira Blog.
 */

function ensure_php_ini_configured() {
    $iniPath = php_ini_loaded_file();
    if (!$iniPath) {
        $phpDir = dirname(PHP_BINARY);
        $iniPath = $phpDir . DIRECTORY_SEPARATOR . 'php.ini';
    }
    if ($iniPath && file_exists($iniPath)) {
        $content = file_get_contents($iniPath);
        $modified = false;
        $phpDir = dirname($iniPath);
        $extDir = $phpDir . DIRECTORY_SEPARATOR . 'ext';

        if (preg_match('/^;?extension_dir\s*=\s*".*?"/m', $content)) {
            $newExt = 'extension_dir = "' . addslashes($extDir) . '"';
            $content = preg_replace('/^;?extension_dir\s*=\s*".*?"/m', $newExt, $content);
            $modified = true;
        }

        $extensions = ['pdo_mysql', 'mysqli', 'gd', 'mbstring', 'fileinfo', 'curl', 'openssl', 'pdo_sqlite'];
        foreach ($extensions as $ext) {
            if (preg_match('/^;extension=' . preg_quote($ext, '/') . '/m', $content)) {
                $content = preg_replace('/^;extension=' . preg_quote($ext, '/') . '/m', 'extension=' . $ext, $content);
                $modified = true;
            }
        }

        if ($modified) {
            file_put_contents($iniPath, $content);
        }
    }
}

ensure_php_ini_configured();

// FIX: Updated database config path to src/core/db/conn.php
$configFile = __DIR__ . '/../src/core/db/conn.php';
if (!file_exists($configFile)) {
    die("[-] Error: Database configuration file not found at: {$configFile}\n");
}

require_once $configFile;

echo "====================================================\n";
echo "       OdaKira Database Provisioning Utility        \n";
echo "====================================================\n\n";

function try_start_db_engine() {
    $searchPaths = [
        'C:\Program Files\MariaDB 12.3\bin\mysqld.exe',
        'C:\Program Files\MariaDB 11.4\bin\mysqld.exe',
        'C:\Program Files\MariaDB 10.11\bin\mysqld.exe',
        'C:\Program Files\MySQL\MySQL Server 8.4\bin\mysqld.exe',
        'C:\Program Files\MySQL\MySQL Server 8.0\bin\mysqld.exe',
        'C:\xampp\mysql\bin\mysqld.exe',
        'C:\tools\mariadb\bin\mysqld.exe',
        'C:\tools\mysql\bin\mysqld.exe',
    ];

    foreach ($searchPaths as $exe) {
        if (file_exists($exe)) {
            $binDir = dirname($exe);
            $parentDir = dirname($binDir);
            $dataDir = $parentDir . DIRECTORY_SEPARATOR . 'data';
            echo "[*] Automatically starting background database engine ({$exe})...\n";
            pclose(popen("start \"\" /B \"{$exe}\" --datadir=\"{$dataDir}\"", "r"));
            return true;
        }
    }
    return false;
}

echo "[*] Connecting to MySQL server at " . DBHOST . " as user '" . DBUSER . "'...\n";

$pdo = null;
$maxRetries = 10;
$engineAttempted = false;

for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
    foreach (array_unique([DBHOST, '127.0.0.1', 'localhost']) as $h) {
        try {
            $pdo = new PDO("mysql:host=" . $h, DBUSER, DBPASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            echo "[+] Successfully connected to MySQL server ({$h}).\n";
            break 2;
        } catch (PDOException $e) {
            // Continue trying other hosts or retry loop
        }
    }

    if (!$engineAttempted) {
        $engineAttempted = true;
        try_start_db_engine();
    }
    if ($attempt < $maxRetries) {
        echo "[*] Waiting for database engine to become ready (attempt {$attempt}/{$maxRetries})...\n";
        sleep(1);
    } else {
        echo "[-] Connection failed to MySQL.\n";
        echo "[!] Please ensure your MySQL / MariaDB service is running.\n";
        exit(1);
    }
}

try {
    echo "[*] Ensuring database `" . DBNAME . "` exists...\n";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DBNAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `" . DBNAME . "`");

    // Check if tables already exist
    $tablesStmt = $pdo->query("SHOW TABLES LIKE 'users'");
    $existing = $tablesStmt->fetch();

    if ($existing) {
        echo "[+] Database `" . DBNAME . "` already contains tables. Verifying structure...\n";
    } else {
        // FIX: Updated SQL dump path to src/myblog_db.sql
        $sqlFile = __DIR__ . '/../src/myblog_db.sql';
        if (file_exists($sqlFile)) {
            echo "[*] Importing schema and seed data from " . basename($sqlFile) . "...\n";
            $sqlContent = file_get_contents($sqlFile);
            $pdo->exec($sqlContent);
            echo "[+] Initial database schema imported successfully!\n";
        } else {
            echo "[!] SQL dump file not found at: {$sqlFile}\n";
        }
    }

    echo "\n[OK] Database setup complete! Database `" . DBNAME . "` is ready for use.\n";
} catch (PDOException $e) {
    echo "[-] Database error: " . $e->getMessage() . "\n";
    exit(1);
}
