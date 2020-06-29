<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sunrise\Http\Message\ResponseFactory;
use Sunrise\Http\Router\RequestHandler\CallableRequestHandler;
use Sunrise\Http\Router\RouteCollector;
use Sunrise\Http\Router\Router;
use Sunrise\Http\ServerRequest\ServerRequestFactory;

use function Sunrise\Http\Router\emit;

require __DIR__ . '/../vendor/autoload.php';

$router = new Router();
$routeCollector = new RouteCollector();

$routeCollector->get('home', '/', new CallableRequestHandler(function (ServerRequestInterface $request) : ResponseInterface {
    return (new ResponseFactory)->createResponse(200);
}));

$routeCollector->get('userRead', '/user/{id}', new CallableRequestHandler(function (ServerRequestInterface $request) : ResponseInterface {
    $response = (new ResponseFactory)->createResponse(200);
    $response->getBody()->write($request->getAttribute('id'));

    return $response;
}));

$routeCollector->get('userList', '/user', new CallableRequestHandler(function (ServerRequestInterface $request) : ResponseInterface {
    return (new ResponseFactory)->createResponse(200);
}));

$router->addRoute(...$routeCollector->getCollection()->all());

emit($router->handle(ServerRequestFactory::fromGlobals()));
