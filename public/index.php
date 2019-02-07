<?php
require __DIR__ . '/../vendor/autoload.php';

use DI\ContainerBuilder;
use Psr\Http\Message\ServerRequestInterface;


$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/config.php');
$containerBuilder->addDefinitions(__DIR__ . '/_config/config.php');
$containerBuilder->addDefinitions(['routes' => require __DIR__ . '/routes.php']);
$container = $containerBuilder->build();


$container
    ->get('app')
    ->run($container->get(ServerRequestInterface::class));
