<?php

require_once __DIR__ . '/../help.php';

function makeMigration($name, $type) {
    if (in_array($name,['help','-h','--help'])){
        showMigrationHelp();
        exit;
    }
    
    $date = date('Y_m_d_His');
    $filename = "database/migrations/{$date}_{$name}.php";

    $template = <<<PHP
<?php

return [
    // TODO: Add your SQL query for creation or modification here
    // Example:
    // "CREATE TABLE users (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255))"
    
];
PHP;
    createFiles($filename,$template,$type);
} 