<?php
use Psr\Container\ContainerInterface;

use Omega\Core\{
    RendererInterface,
    EngineInterface,
    Bootstrap
};
use Omega\Renderers\Html;

use Psr\Http\Message\ResponseFactoryInterface;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Message\ServerRequestInterface;


return [

    /** App Interfaces */
    EngineInterface::class => function (ContainerInterface $c) {
        return $c->get('factories')['apps'][$c->get('app.engine')];
    },
    EngineInterface::class => \DI\autowire(\Omega\Engines\Slim::class),
    RendererInterface::class => function (ContainerInterface $c) {
        return new Html($c->get('path.template') . 'html/');
    },
    //ErrorHandlerInterface::class => DI\autowire(WhoopsHandler::class),

    'factories' => require __DIR__ . '/factories.php',
    'app' => function (ContainerInterface $c) {
        return $c->get(Bootstrap::class)
            ->setEngine($c->get(EngineInterface::class))
            ->addRoutes($c->get('routes'))
            //->addErrorHandler($c->get(ErrorHandlerInterface::class))
            ->getApp();
    },


    /** Other Implementations */

    Twig_Environment::class => function (ContainerInterface $c) {
        $loader = new Twig_Loader_Filesystem($c->get('path.template') . 'twig/');
        return new Twig_Environment($loader);
    },
    //\Whoops\Run::class => DI\autowire()->method('pushHandler', DI\get(PrettyPageHandler::class)),

    ResponseFactoryInterface::class => DI\autowire(Psr17Factory::class),
    /*
    Notre Psr17Factory fait aussi office de :
        - ServerRequestFactoryInterface
        - UriFactoryInterface
        - UploadedFileFactoryInterface
        - StreamFactoryInterface
    */
    ServerRequestCreator::class => DI\autowire()->constructor(
        DI\get(ResponseFactoryInterface::class),
        DI\get(ResponseFactoryInterface::class),
        DI\get(ResponseFactoryInterface::class),
        DI\get(ResponseFactoryInterface::class)
    ),
    ServerRequestInterface::class => function (ContainerInterface $c) {
        return $c->get(ServerRequestCreator::class)->fromGlobals();
    },
    \Slim\App::class => DI\autowire()->constructor(DI\get(ResponseFactoryInterface::class)),
];
