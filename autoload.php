<?php
$coreDirectory = __DIR__ . '/system/core/';
$databaseDirectory = __DIR__ . '/system/database/';
$libsDirectory = __DIR__ . '/app/libs/';

$databaseFiles = scandir($databaseDirectory);
foreach ($databaseFiles as $file) {
    $filePath = $databaseDirectory . $file;
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

$libFiles = scandir($libsDirectory);
foreach ($libFiles as $file) {
    $filePath = $libsDirectory . $file;
    if (is_file($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
        require_once $filePath;
    }
}
