<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/core/Controller.php';

// Auto-load simple (app/controllers, app/models)
spl_autoload_register(function ($class) {
    $class = ltrim($class, '\\');
    $paths = [
        __DIR__ . '/../app/controllers/' . $class . '.php',
        __DIR__ . '/../app/models/' . $class . '.php',
        __DIR__ . '/../app/core/' . $class . '.php',
    ];
    foreach ($paths as $p) {
        if (file_exists($p)) { require_once $p; return; }
    }
});

// Route via query string : ?c=home&a=index
$controllerName = (string)($_GET['c'] ?? 'home');
$actionName = (string)($_GET['a'] ?? 'index');

$controllerClass = ucfirst(strtolower($controllerName)) . 'Controller';
$actionMethod = strtolower($actionName);

try {
    if (!class_exists($controllerClass)) {
        throw new Exception('Page introuvable.');
    }
    $controller = new $controllerClass();
    if (!method_exists($controller, $actionMethod)) {
        throw new Exception('Action introuvable.');
    }
    $controller->$actionMethod();
} catch (Throwable $e) {
    http_response_code(404);
    $message = $e->getMessage();
    include __DIR__ . '/../app/views/errors/404.php';
}

