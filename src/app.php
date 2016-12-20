<?php

use SON\View\ViewRenderer;
use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application();

$app['debug'] = true;

$app['view.config'] = [
    'path_templates' => __DIR__ . '/../templates'
];

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'son_silex_basico',
        'user' => 'root',
        'password' => 'root'
    ),
));

$app['view.renderer'] = function () use ($app) {
    $pathTemplates = $app['view.config']['path_templates'];
    return new ViewRenderer($pathTemplates);
};

$app->get('/create-table', function (Silex\Application $app) {
    $file = fopen(__DIR__ . '/../data/schema.sql', 'r');
    while ($line = fread($file, 4096)) {
        $app['db']->executeQuery($line);
    }
    fclose($file);
    return "Tabelas criadas";
});

$site = include __DIR__ . '/controllers/site.php';
$app->mount('/', $site);
$app->mount('/admin', function($admin) use($app){
    $post = include __DIR__ . '/controllers/posts.php';
    $admin->mount('/posts', $post);
});

$app->error(function(\Exception $e, Request $request, $code) use($app){
    switch ($code){
        case 404:
            return $app['view.renderer']->render('errors/404', [
                'message' => $e->getMessage()
            ]);
    }
});

/*$app->get('/home', function () use ($app) {
    dump($app);
    return $app['view.renderer']->render('home');
});

$app->post('/get-name/{param1}/{param2}',
    function (Request $request, Silex\Application $app, $param2, $param1) {
        $name = $request->get('name', 'sem nome');
        return $app['view.renderer']->render('get-name', [
            'name' => $name,
            'param1' => $param1,
            'param2' => $param2
        ]);
    });*/


$app->run();

