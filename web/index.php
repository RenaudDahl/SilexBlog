<?php


use Silex\Provider\FormServiceProvider;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new FormServiceProvider());

require __DIR__.'/../app/config/dev.php';
require __DIR__.'/../app/app.php';
require __DIR__.'/../app/routes.php';

$app->run();