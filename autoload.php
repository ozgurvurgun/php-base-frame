<?php
$coreDirectory = __DIR__ . '/system/core/';
$databaseDirectory = __DIR__ . '/system/database/';
$helpersCoreDirectory = __DIR__ . '/system/core/helpers/';
$helpersAppDirectory = __DIR__ . '/app/controllers/helpers/';


$databaseFiles = scandir($databaseDirectory);
foreach ($databaseFiles as $file) {
    $filePath = $databaseDirectory . $file;
    if (is_file($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
        require_once $filePath;
    }
}

$coreHelperFiles = scandir($helpersCoreDirectory);
foreach ($coreHelperFiles as $file) {
    $filePath = $helpersCoreDirectory . $file;
    if (is_file($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
        require_once $filePath;
    }
}

$coreFiles = scandir($coreDirectory);
foreach ($coreFiles as $file) {
    $filePath = $coreDirectory . $file;
    if (is_file($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
        require_once $filePath;
    }
}

$helperAppFiles = scandir($helpersAppDirectory);
foreach ($helperAppFiles as $file) {
    $filePath = $helpersAppDirectory . $file;
    if (is_file($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
        require_once $filePath;
    }
}