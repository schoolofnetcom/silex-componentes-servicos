<?php

use SON\View\ViewRenderer;
use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application();

$app['debug'] = true;

include __DIR__ . '/services.php';
include __DIR__ . '/routes.php';

$app->run();

