<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 01/07/15
 * Time: 14:58
 */


// Liste des articles
$app->get('/blog', 'SilexBlog\Controller\HomeController::indexAction');

// Affichage d'un seul article
$app->get('/blog/{id}', 'SilexBlog\Controller\HomeController::articleAction');


// Back-office

// Création d'article
$app->post('/admin/create', 'SilexBlog\Controller\AdminController::createAction');



// Modification d'article
$app->post('/admin/update/{id}', 'SilexBlog\Controller\AdminController::updateAction');


//Suppression d'article
$app->post('/admin/delete/{id}', 'SilexBlog\Controller\AdminController::deleteAction');