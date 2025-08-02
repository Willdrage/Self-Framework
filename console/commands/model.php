<?php

require_once __DIR__ . '/../help.php';

function makeModel($name, $type) {
    if (in_array($name,['help','-h','--help'])){
        showModelHelp();
        exit;
    }
    
    $name = ucfirst($name);
    $filename = "app/Models/{$name}.php";
    $table=strtolower($name)."s";
    $template = <<<PHP
<?php

namespace App\Models;

class {$name} extends Model {
    protected \$table = '{$table}';
}
PHP;
    createFiles($filename,$template,$type);
} 