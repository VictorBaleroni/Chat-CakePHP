<?php

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return function (RouteBuilder $routes): void {

    $routes->connect('/', ['controller' => 'Pages', 'action' => 'index']);
    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
};
