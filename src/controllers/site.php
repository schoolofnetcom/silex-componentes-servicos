<?php

$site = $app['controllers_factory'];
$site->get('/home', function () use ($app) {
    return $app['twig']->render('home.html.twig');
});

$site->get('/fale-conosco', function () use ($app) {
    return "<h1>Fale Conosco</h1>";
});


return $site;