<?php
require __DIR__ . "/../vendor/autoload.php";

function layout(string $layoutName) {
    $_SERVER['PAGE_LAYOUT'] = $layoutName;
}

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $routeFiles = glob(__DIR__ . "/../route/*.php");

    foreach($routeFiles as $routeFile) {
        $routePattern = "/" . str_replace(".", "/", basename($routeFile, ".php"));

        $r->addRoute(['GET','POST'], $routePattern, function() use ($routeFile) {
            ob_start();
            require $routeFile;

            //render the layout, if it is set
            if (isset($_SERVER['PAGE_LAYOUT'])) {
                $layoutName = $_SERVER['PAGE_LAYOUT'];
                // End buffering and store output in $content
                $content = ob_get_clean();
                // Include the base layout
                $layoutFilePath = __DIR__ . "/../layout/$layoutName.php";
                if (file_exists($layoutFilePath)) {
                    require $layoutFilePath;
                }
            } else {
                $content = ob_get_clean();
                echo $content;
            }
        });
    }
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
case FastRoute\Dispatcher::NOT_FOUND:
    // ... 404 Not Found
    header("HTTP/1.1 404 Not Found");
    break;
case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
    $allowedMethods = $routeInfo[1];
    // ... 405 Method Not Allowed
    header("HTTP/1.1 405 Method Not Found");
    break;
case FastRoute\Dispatcher::FOUND:
    $handler = $routeInfo[1];
    $routeParams = $routeInfo[2];
    $_SERVER['ROUTE_PARAMS'] = $routeParams;
    $handler();
    break;
}
