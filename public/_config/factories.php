<?php

use Psr\Container\ContainerInterface;
use Omega\Core\RendererInterface;
use Omega\Renderers\Html;
use Omega\Engines\Slim;

return [
    'controllers' => function (ContainerInterface $c) {
        return function ($className) use ($c) {
            $controller = $c->get($className);
            $controller->setRenderer($c->get(RendererInterface::class));
            return $controller;
        };
    },
    'renderers' => [
        //'twig' => DI\autowire(RendererTwig::class),
        'html' => function (ContainerInterface $c) {
            return \DI\autowire(Html::class)->constructor($c->get('path.template') . 'html/');
        }
    ],
    'apps' => [
        'slim' => function (ContainerInterface $c) {
            return $c->get(Slim::class);
        }
    ]
];