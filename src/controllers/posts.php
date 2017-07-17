<?php

use Symfony\Component\HttpFoundation\Request;

$post = $app['controllers_factory'];
$post->get('/create', function () use ($app) {
    return $app['twig']->render('posts/create.html.twig');
})->bind('admin.posts.create');

$post->post('/create', function (Request $request) use ($app) {
    /** @var \Doctrine\DBAL\Connection $db */
    $db = $app['db'];
    $data = $request->request->all();
    $db->insert('posts', [
        'title' => $data['title'],
        'content' => $data['content']
    ]);
    $url = $app['url_generator']->generate('admin.posts.index');
    return $app->redirect($url);
})->bind('admin.posts.store');

$post->get('/', function () use ($app) {
    dump("luiz carlos");
    /** @var \Doctrine\DBAL\Connection $db */
    $db = $app['db'];
    $sql = "SELECT * FROM posts;";
    $posts = $db->fetchAll($sql);
    return $app['twig']->render('posts/list.html.twig', [
        'posts' => $posts
    ]);
})->bind('admin.posts.index');

$post->get('/edit/{id}', function ($id) use ($app) {
    /** @var \Doctrine\DBAL\Connection $db */
    $db = $app['db'];
    $sql = "SELECT * FROM posts WHERE id = ?;";
    $post = $db->fetchAssoc($sql, [$id]);
    if(!$post){
        $app->abort(404, "Post não encontrado!");
    }
    return $app['twig']->render('posts/edit.html.twig', ['post' => $post]);
})->bind('admin.posts.edit');

$post->post('/edit/{id}', function (Request $request, $id) use ($app) {
    /** @var \Doctrine\DBAL\Connection $db */
    $db = $app['db'];
    $sql = "SELECT * FROM posts WHERE id = ?;";
    $post = $db->fetchAssoc($sql, [$id]);
    if(!$post){
        $app->abort(404, "Post não encontrado!");
    }
    $data = $request->request->all();
    $db->update('posts', [
        'title' => $data['title'],
        'content' => $data['content']
    ], ['id' => $id]);
    $url = $app['url_generator']->generate('admin.posts.index');
    return $app->redirect($url);
})->bind('admin.posts.update');

$post->get('/delete/{id}', function ($id) use ($app) {
    /** @var \Doctrine\DBAL\Connection $db */
    $db = $app['db'];
    $sql = "SELECT * FROM posts WHERE id = ?;";
    $post = $db->fetchAssoc($sql, [$id]);
    if(!$post){
        $app->abort(404, "Post não encontrado!");
    }
    $db->delete('posts', ['id' => $id]);
    $url = $app['url_generator']->generate('admin.posts.index');
    return $app->redirect($url);
})->bind('admin.posts.destroy');

return $post;