<?php
// Iniciamos la sesión en toda la aplicación para recordar quién inició sesión
session_start();

// Autocarga de clases: busca automáticamente controladores, modelos y configuración
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/app/controllers/' . $class . '.php',
        __DIR__ . '/app/models/' . $class . '.php',
        __DIR__ . '/app/config/' . $class . '.php'
    ];
    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Leemos la ruta desde la URL (ejemplo: index.php?url=auth/login)
// Si no hay parámetro 'url', por defecto carga 'reportes/index'
$url = isset($_GET['url']) ? trim($_GET['url'], '/') : 'reportes/index';
$urlParts = explode('/', $url);

// Determinamos qué Controlador y qué Método (acción) ejecutar
$controllerName = 'ReporteController';
$action = 'index';

if ($urlParts[0] === 'auth') {
    $controllerName = 'AuthController';
    $action = $urlParts[1] ?? 'login';
} elseif ($urlParts[0] === 'reportes') {
    $controllerName = 'ReporteController';
    $action = $urlParts[1] ?? 'index';
}

// Verificamos que el controlador y el método existan antes de ejecutarlos
if (class_exists($controllerName) && method_exists($controllerName, $action)) {
    $controller = new $controllerName();
    $controller->$action();
} else {
    header("Location: index.php?url=reportes/index");
    exit();
}