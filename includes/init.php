<?php
declare(strict_types=1);

$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');

session_name('SPORTSHUB_SESSION');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => $isHttps,
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();

header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: strict-origin-when-cross-origin');

$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
$directory = dirname($scriptName);
if (str_ends_with($directory, '/admin') || str_ends_with($directory, '/student')) {
    $directory = dirname($directory);
}
$basePath = $directory === '/' || $directory === '.' ? '' : rtrim($directory, '/');
define('BASE_PATH', $basePath);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/auth.php';

set_exception_handler(function (Throwable $exception) {
    error_log($exception->getMessage());
    http_response_code(500);
    $title = 'SportsHub could not complete this request';
    echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>SportsHub error</title><style>body{font-family:Arial,sans-serif;background:#f4f7f5;color:#14231c;display:grid;place-items:center;min-height:100vh;margin:0}.box{max-width:620px;padding:40px}.label{color:#007a3d;font-weight:bold;text-transform:uppercase}h1{font-size:36px}a{color:#007a3d}</style></head><body><main class="box"><p class="label">NSBM SportsHub</p><h1>' . $title . '</h1><p>Please check that MySQL is running and the database has been imported. Setup steps are in README.md.</p><a href="' . e(url('index.php')) . '">Return to the homepage</a></main></body></html>';
});
