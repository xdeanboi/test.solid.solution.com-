<?php

try {

    spl_autoload_register(function (string $className) {
        require_once __DIR__ . '/../src/' . $className . '.php';
    });

    $routes = include __DIR__ . '/../src/routes.php';
    $route = $_GET['route'] ?? '';

    $isRouteFound = false;

    foreach ($routes as $patterns => $controllerAndAction) {
        preg_match($patterns, $route, $matches);
        if (!empty($matches)) {
            $isRouteFound = true;
            break;
        }
    }

    unset($matches[0]);

    if (!$isRouteFound) {
        throw new \Test\Exceptions\NotFoundException('Route is not found!');
    }

    $controllerName = $controllerAndAction[0];
    $controllerAction = $controllerAndAction[1];

    $controller = new $controllerName();
    $controller->$controllerAction(...$matches);
} catch (\Test\Exceptions\NotFoundException $e) {
    $view = new \Test\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('404.php', ['error' => $e->getMessage()], 404);
    return;
} catch (\Test\Exceptions\DbException $e) {
    $view = new \Test\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('500.php', ['error' => $e->getMessage()], 500);
    return;
}