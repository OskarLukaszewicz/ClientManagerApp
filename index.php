<?php

declare(strict_types=1);

use App\Controller\AbstractController;
use App\Controller\ControllerResolver;
use App\Request;

require __DIR__ . '/vendor/autoload.php';

require_once("src/Utils/debug.php");

$configuration = require_once("config/config.php");

$request = new Request($_GET, $_POST, $_SERVER);

try {
    $controllerClass = "App\Controller\\" . ControllerResolver::resolve($request);
    AbstractController::initConfiguration($configuration);
    $controller = new $controllerClass($request);
    $controller->run();
} catch (\Throwable $e) {
    dump($e->getMessage());die;
}