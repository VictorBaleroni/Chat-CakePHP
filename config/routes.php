<?php

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);

    $routes->connect('/', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/create', ['controller' => 'Users', 'action' => 'create']);
    $routes->connect('/store', ['controller' => 'Users', 'action' => 'store']);
    $routes->connect('/profile', ['controller' => 'Users', 'action' => 'edit']);
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
    $routes->connect('/chat', ['controller' => 'Users', 'action' => 'dash']);
};
