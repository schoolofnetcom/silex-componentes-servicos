<?php

use Symfony\Component\HttpFoundation\Request;

$post = $app['controllers_factory'];
$post->get('/create', function () use ($app) {
    return $app['view.renderer']->render('posts/create');
});

$post->post('/create', function (Request $request) use ($app) {
    /** @var \Doctrine\DBAL\Connection $db */
    $db = $app['db'];
    $data = $request->request->all();
    $db->insert('posts', [
        'title' => $data['title'],
        'content' => $data['content']
    ]);
    return $app->redirect('/admin/posts');
});

$post->get('/', function () use ($app) {
    /** @var \Doctrine\DBAL\Connection $db */
    $db = $app['db'];
    $sql = "SELECT * FROM posts;";
    $posts = $db->fetchAll($sql);
    return $app['view.renderer']->render('posts/list', [
        'posts' => $posts
    ]);
});

$post->get('/edit/{id}', function ($id) use ($app) {
    /** @var \Doctrine\DBAL\Connection $db */
    $db = $app['db'];
    $sql = "SELECT * FROM posts WHERE id = ?;";
    $post = $db->fetchAssoc($sql, [$id]);
    if(!$post){
        $app->abort(404, "Post não encontrado!");
    }
    return $app['view.renderer']->render('posts/edit', ['post' => $post]);
});

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
    return $app->redirect('/admin/posts');
});

$post->get('/delete/{id}', function ($id) use ($app) {
    /** @var \Doctrine\DBAL\Connection $db */
    $db = $app['db'];
    $sql = "SELECT * FROM posts WHERE id = ?;";
    $post = $db->fetchAssoc($sql, [$id]);
    if(!$post){
        $app->abort(404, "Post não encontrado!");
    }
    $db->delete('posts', ['id' => $id]);
    return $app->redirect('/admin/posts');
});

return $post;