<?php
require_once "config.php";

$controller = $_GET['c'] ?? 'produto';
$action = $_GET['a'] ?? 'form';

$controllerClass = ucfirst($controller) . 'Controller';
$controllerFile = "controllers/{$controllerClass}.php";

if (!file_exists($controllerFile)) {
    die("Controller não encontrado.");
}

require_once $controllerFile;
$ctrl = new $controllerClass();

if (!method_exists($ctrl, $action)) {
    die("Ação não encontrada.");
}

$ctrl->$action();
