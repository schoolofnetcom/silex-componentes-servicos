<?php


use Symfony\Component\HttpFoundation\Request;

$app->get('/create-table', function (Silex\Application $app) {
    $file = fopen(__DIR__ . '/../data/schema.sql', 'r');
    while ($line = fread($file, 4096)) {
        $app['db']->executeQuery($line);
    }
    fclose($file);
    return "Tabelas criadas";
});

$site = include __DIR__ . '/Controllers/site.php';
$app->mount('/', $site);

$app->mount('/admin', function($admin) use($app){
    //$post = include __DIR__ . '/Controllers/posts.php';
    //$admin->mount('/posts', $post);
    $admin->mount('/posts', function($posts){
        $posts->get('/','posts.controller:index')->bind('admin.posts.index');
        $posts->get('/create', 'posts.controller:create')->bind('admin.posts.create');
        $posts->post('/create', 'posts.controller:store')->bind('admin.posts.store');
        $posts->get('/edit/{id}', 'posts.controller:edit')->bind('admin.posts.edit');
        $posts->post('/edit{id}', 'posts.controller:update')->bind('admin.posts.update');
        $posts->get('/delete/{id}', 'posts.controller:destroy')->bind('admin.posts.destroy');
    });
});

$app->error(function(\Exception $e, Request $request, $code) use($app){
    switch ($code){
        case 404:
            if(!$app['debug']) {
                return $app['twig']->render('errors/404.html.twig', [
                    'message' => 'Página não encontrada'
                ]);
            }
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
