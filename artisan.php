<?php

require_once 'console/help.php';

function createFiles($filename, $template, $type){
    if (file_exists($filename)) {
        showFileExistsError($filename);
        exit;
    }

    file_put_contents($filename, $template);
    showFileCreated($type, $filename);
}

if (!$argc == 3 || in_array($argv[1], ['help','-h','--help'])) {
    showGeneralHelp();
    exit;
}

$type = strtolower($argv[1]);
$name = $argv[2] ?? '';

if($name==='' && in_array($type, ['migration','controller','model'])){
    showMissingNameError($type);
    exit;
}

switch ($type){
    case 'migration':
        require_once "console/commands/migration.php";
        makeMigration($name,$type);
        break;

    case 'controller':
    case'resource':
        require_once "console/commands/controller.php";
        makeController($name,$type);
        break;

    case 'model':
        require_once "console/commands/model.php";
        makeModel($name,$type);
        break;

    case 'migrate':
        require_once "console/commands/migrate.php";
        migrate();
        break;

    default:
        showUnknownTypeError($type);
        exit;
}

