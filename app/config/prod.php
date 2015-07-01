<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 01/07/15
 * Time: 15:33
 */

$app['db.options'] = array(
    'driver'    => 'pdo_mysql',
    'charset'   => 'utf-8',
    'host'      => 'localhost',
    'port'      => '3306',
    'dbname'    => 'blog_silex',
    'user'      => 'renaud',
    'password'  => 'secret',
);