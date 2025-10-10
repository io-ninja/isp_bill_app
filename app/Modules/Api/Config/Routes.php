<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('api', ['namespace' => 'App\Modules\Api\Controllers'], function ($subroutes) {});
