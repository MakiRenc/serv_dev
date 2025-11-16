<?php

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
	echo 'Страница не найдена!';
	return;
}

unset($matches[0]);

$controllerName = $controllerAndAction[0];
$actionName = $controllerAndAction[1];

$controller = new $controllerName();
$controller->$actionName(...$matches);


// Добавляем экшн в контроллер (либо создаём ещё и новый контроллер);
// Добавляем для него роут в routes.php;
// Описываем логику внутри экшена и в конце вызываем у компонента view метод renderHtml();
// Создаём шаблон для вывода результата.