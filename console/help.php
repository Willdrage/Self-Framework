<?php

// Messages d'aide généraux
function showGeneralHelp() {
    echo "Usage: php artisan.php [command] [name]\n";
    echo "Available commands:\n";
    echo "  controller  - Create a new controller\n";
    echo "  model       - Create a new model\n";
    echo "  migration   - Create a new migration\n";
    echo "  migrate     - Run pending migrations\n";
    echo "\nFor help on a specific command:\n";
    echo "  php artisan.php [command] -h\n";
    echo "  Example: php artisan.php controller -h\n";
}

// Conventions pour les contrôleurs
function showControllerHelp() {
    echo "Controller naming conventions:\n";
    echo "- Use PascalCase for controller names (e.g., UserController).\n";
    echo "- You can use subfolders by separating with '/'.\n";
    echo "- Example:\n";
    echo "    php artisan.php controller admin/UserController\n";
    echo "  This will generate a file like:\n";
    echo "    app/Controllers/Admin/UserController.php\n";
    echo "\nGenerated controller will include:\n";
    echo "- Proper namespace based on folder structure\n";
    echo "- Extends base Controller class\n";
    echo "- Default index() method\n";
}

// Conventions pour les modèles
function showModelHelp() {
    echo "Model naming conventions:\n";
    echo "- Use PascalCase for model names (e.g., User).\n";
    echo "- The filename will be app/Models/ModelName.php\n";
    echo "- Example:\n";
    echo "    php artisan.php model User\n";
    echo "  This will generate a file like:\n";
    echo "    app/Models/User.php\n";
    echo "\nGenerated model will include:\n";
    echo "- Proper namespace (App\\Models)\n";
    echo "- Extends base Model class\n";
    echo "- Table name automatically set to lowercase + 's'\n";
}

// Conventions pour les migrations
function showMigrationHelp() {
    echo "Migration naming conventions:\n";
    echo "- The filename will start with the current date and time (Y_m_d_His format).\n";
    echo "- Provide a descriptive name for the migration (e.g., create_users_table).\n";
    echo "- Example:\n";
    echo "    php artisan.php migration create_users_table\n";
    echo "  This will generate a file like:\n";
    echo "    database/migrations/2025_07_12_153045_create_users_table.php\n";
    echo "\nMigration file structure:\n";
    echo "- Returns an array of SQL queries\n";
    echo "- Each query will be executed in order\n";
    echo "- Example queries:\n";
    echo "  \"CREATE TABLE users (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255))\"\n";
    echo "  \"ALTER TABLE users ADD COLUMN email VARCHAR(255)\"\n";
}

// Aide pour la commande migrate
function showMigrateHelp() {
    echo "Migrate Command:\n";
    echo "- Executes all pending database migrations.\n";
    echo "- Usage: php artisan.php migrate\n";
    echo "- This will run all migration files in database/migrations/ that haven't been executed yet.\n";
    echo "\nMigration process:\n";
    echo "- Creates migrations table if it doesn't exist\n";
    echo "- Checks which migrations have already been run\n";
    echo "- Executes pending migrations in order\n";
    echo "- Records completed migrations in database\n";
    echo "\nMigration status:\n";
    echo "- ⏳ Running migration: filename.php\n";
    echo "- Migration filename.php completed successfully.\n";
}

// Messages d'erreur
function showMissingNameError($type) {
    echo "Error: Missing name.\n";
    echo "Tip: You can type 'help', '-h' or '--help' as the [name] parameter to see naming conventions.\n";
    echo "Usage: php artisan.php [type] [name]\n";
    echo "Example: php artisan.php $type -h\n";
}

function showUnknownTypeError($type) {
    echo "Type '$type' unknown. Available commands: controller, model, migration, migrate\n";
    echo "Use 'php artisan.php help' to see all available commands.\n";
}

// Messages de succès
function showFileCreated($type, $filename) {
    echo ucfirst($type) . " file created: $filename\n";
}

function showMigrationRunning($filename) {
    echo "⏳ Running migration: $filename\n";
}

function showMigrationCompleted($filename) {
    echo "Migration $filename completed successfully.\n";
}

// Messages d'erreur de base de données
function showDatabaseConnectionError($message) {
    echo "Connection failed: " . $message . "\n";
}

function showFileExistsError($filename) {
    echo "ERROR : $filename file already exist. Exit.\n";
} 