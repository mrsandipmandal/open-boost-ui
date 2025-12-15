<?php
$json = file_get_contents(__DIR__ . '/../composer.json');
$data = json_decode($json, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo 'JSON Error: ' . json_last_error_msg() . PHP_EOL;
    exit(1);
}
echo 'OK' . PHP_EOL;
