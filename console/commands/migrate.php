<?php

require_once __DIR__ . '/../help.php';

function migrate() {
    $config = require('config/config.php');

    try {
        $dsn ="mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4";
        $db = new PDO($dsn, DB_USER,DB_PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch (PDOException $e) {
        showDatabaseConnectionError($e->getMessage());
        exit;
    }
    
    $db->exec("CREATE TABLE IF NOT EXISTS migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255) NOT NULL,
        run_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

    $migrationFiles= glob('database/migrations/*.php');
    $doneMigration= $db->query("SELECT migration FROM migrations")->fetchAll((PDO::FETCH_COLUMN));

        foreach ($migrationFiles as $file){
        $filename= basename($file);
        if (!in_array($filename, $doneMigration)){
            showMigrationRunning($filename);
            $queries=include($file);
            foreach ((array)$queries as  $query) {
                $db->exec($query);
            }
            $stmt = $db->prepare('INSERT INTO migrations (migration) VALUES (?)');
            $stmt->execute([$filename]);
            showMigrationCompleted($filename);
        }
    }
} 