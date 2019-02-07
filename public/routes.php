<?php

use Psr\Container\ContainerInterface;
use Omega\Core\Routes\SimpleRoute;
use Omega\Core\RendererInterface;
use FormDev\TauxCalc\Controllers\{
    IndexController,
    EcheanceController,
    PretController
};

$f = function ($name) {
    return function (ContainerInterface $c) use ($name) {
        return $c->get('factories')['controllers']($name);
    };
};

$routes = [
    'index' => [
        'GET',
        '/',
        \DI\autowire(IndexController::class)
            ->method('setRenderer', \DI\get(RendererInterface::class))
    ],
    'echeances' => ['POST', '/echeance', \DI\get(EcheanceController::class)],
    'pret' => ['POST', '/pret', \DI\get(PretController::class)]
];

return array_merge(...array_map(function ($rawRoute, $k) use ($f) {
    return [$k => \DI\autowire(SimpleRoute::class)->constructor(...$rawRoute)];
}, $routes, array_keys($routes)));
