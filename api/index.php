<?php

chdir(dirname(__DIR__));

// Setup direktori tmp
$tmpDir = '/tmp';

// Buat folder views di /tmp (writable di Vercel)
if (!is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0775, true);
}
if (!is_dir('/tmp/cache')) {
    mkdir('/tmp/cache', 0775, true);
}

// Override temp directory
putenv('TMPDIR=' . $tmpDir);
putenv('TEMP=' . $tmpDir);
putenv('TMP=' . $tmpDir);
putenv('VIEW_COMPILED_PATH=/tmp/views');

// Buat semua folder storage yang dibutuhkan
$dirs = [
    __DIR__ . '/../storage/logs',
    __DIR__ . '/../storage/framework/cache',
    __DIR__ . '/../storage/framework/cache/data',
    __DIR__ . '/../storage/framework/sessions',
    __DIR__ . '/../storage/framework/views',
    __DIR__ . '/../storage/framework/testing',
    __DIR__ . '/../bootstrap/cache',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
}

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Override view compiled path
$app->bind('path.storage', function() {
    return __DIR__ . '/../storage';
});

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);