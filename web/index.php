<?php

use Symfony\Component\HttpFoundation\Request;
use SilexBlog\Entity\Article;
use Silex\Provider\FormServiceProvider;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_sqlite',
        'path'     => __DIR__.'/app.db',
        'dbname'   => 'blog_silex',
        'host'     => 'localhost',
        'user'     => 'renaud',
        'password' => 'secret',
    ),
));

require __DIR__.'/../app/routes.php';


$app->run();