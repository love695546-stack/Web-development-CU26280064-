<?php
// Q4: Front Controller & Simple Router
// Q10: Secure Session settings
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => true,      // HTTPS required
    'httponly' => true,    // Prevent XSS access
    'samesite' => 'Strict' // Prevent CSRF
]);
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/ProductController.php';

// Q16: Custom Error Logging & Hiding Errors
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../logs/error.log');

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Route parsing
if ($requestUri === '/' || $requestUri === '/products') {
    $controller = new ProductController();
    $controller->index();
} elseif (strpos($requestUri, '/api/products') === 0) {
    $controller = new ProductController();
    $parts = explode('/', trim($requestUri, '/'));
    $id = isset($parts[2]) ? (int)$parts[2] : null;
    $controller->handleApi($method, $id);
} else {
    http_response_code(404);
    require_once __DIR__ . '/../views/errors/404.php';
}
