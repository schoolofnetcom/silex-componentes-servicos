<?php

use Silex\Provider;

$app->register(new \SON\Providers\AppServiceProvider(), [
    'injector.interfaces' => [
        'db' => \SON\Service\DoctrineDbalInjectorInterface::class,
        'url_generator' => \SON\Service\UrlGeneratorInjectorInterface::class,
        'twig' => \SON\Service\TwigInjectorInterface::class
    ]
]);

$app->register(new Provider\HttpFragmentServiceProvider());
$app->register(new Provider\ServiceControllerServiceProvider());
$app->register(new Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__ . '/../templates',
    'twig.options' => [
        'cache' => __DIR__ . '/../data/cache/twig'
    ]
]);

$app->register(new Provider\AssetServiceProvider(), [
    'assets.version' => 'v2',
    'assets.version_format' => '%s?version=%s'
]);

$app->register(new Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'son_silex_basico',
        'user' => 'root',
        'password' => 'root'
    ),
));

if ($app['debug']) {
    $app->register(new Provider\VarDumperServiceProvider());
    $app->register(new Provider\WebProfilerServiceProvider(), [
        'profiler.cache_dir' => __DIR__ . '/../data/cache/profiler',
        'profiler.mount_prefix' => '/_profiler'
    ]);
}