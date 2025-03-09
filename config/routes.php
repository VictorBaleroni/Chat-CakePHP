<?php

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);

    $routes->connect('/', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/create', ['controller' => 'Users', 'action' => 'create']);
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
    $routes->connect('/pages', ['controller' => 'Pages', 'action' => 'index']);
    
};
