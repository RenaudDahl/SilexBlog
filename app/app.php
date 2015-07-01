<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 01/07/15
 * Time: 15:31
 */

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());

// Register services.
$app['dao.article'] = $app->share(function ($app) {
    return new SilexBlog\DAO\ArticleDAO($app['db']);
});