<?php

use MyProject\View\View;
use MyProject\Exceptions\NotFoundException;

try {
	spl_autoload_register(function (string $className) {
		require_once __DIR__ . '/../src/' . $className . '.php';
	});

	$route = $_GET['route'] ?? '';
	$routes = require __DIR__ . '/../src/routes.php';
	$isRouteFound = false;

	foreach ($routes as $pattern => $controllerAndAction) {
		preg_match($pattern, $route, $matches);
		if (!empty($matches)) {
			$isRouteFound = true;
			break;
		}
	}

	if (!$isRouteFound) {
		throw new NotFoundException();
	}

	unset($matches[0]);

	$controllerName = $controllerAndAction[0];
	$actionName = $controllerAndAction[1];
	$controller = new $controllerName();
	$controller->$actionName(...$matches);
} catch (\MyProject\Exceptions\DbException $e) {
	$view = new View(__DIR__ . '/../templates/errors');
	$view->renderHtml('500.php', ['error' => $e->getMessage()], 500);
} catch (\MyProject\Exceptions\NotFoundException $e) {
	$view = new \MyProject\View\View(__DIR__ . '/../templates/errors');
	$view->renderHtml('404.php', ['error' => $e->getMessage()], 404);
}

// Добавляем экшн в контроллер (либо создаём ещё и новый контроллер);
// Добавляем для него роут в routes.php;
// Описываем логику внутри экшена и в конце вызываем у компонента view метод renderHtml();
// Создаём шаблон для вывода результата.