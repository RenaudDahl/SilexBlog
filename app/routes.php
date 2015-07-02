<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 01/07/15
 * Time: 14:58
 */

use Symfony\Component\HttpFoundation\Request;
use SilexBlog\Entity\Article;
use SilexBlog\Form\Type\ArticleType;


// Liste des articles
$app->get('/blog', function () use ($app) {

    $articles = $app['dao.article']->findAll();
    $output = array();
    foreach($articles as $post){
        $output[] = array(
            'id'    => $post->getId(),
            'titre' => $post->getTitle(),
        );
    }

    return $app->json($output);
});

// Affichage d'un seul article
$app->get('/blog/{id}', function ($id) use ($app) {

    $article = $app['dao.article']->findOne($id);
    if (!isset($article)) {
        $app->abort(404, "L'article que vous recherchez n'existe pas.");
    }

    $output = array(
        'titre'   => $article->getTitle(),
        'contenu' => $article->getContent(),
    );

    return $app->json($output);
});


// Back-office

// Création d'article
$app->post('/admin/create', function(Request $request) use ($app) {

    if (!$request->request->has('title')) {
        return $app->json('Missing required parameter: title', 400);
    }
    if (!$request->request->has('content')) {
        return $app->json('Missing required parameter: content', 400);
    }

    $article = new Article();
    $article->setTitle($request->request->get('title'));
    $article->setContent($request->request->get('content'));
    $app['dao.article']->save($article);

    $responseData = array(
        'id' => $article->getId(),
        'title' => $article->getTitle(),
        'content' => $article->getContent()
    );
    return $app->json($responseData, 201);
});



// Modification d'article
$app->post('/admin/update/{id}', function(Request $request, $id) use($app) {

    $article = $app['dao.article']->findOne($id);

    if (!$request->request->has('title')) {
        return $app->json('Missing required parameter: title', 400);
    }
    if (!$request->request->has('content')) {
        return $app->json('Missing required parameter: content', 400);
    }

    $article->setTitle($request->request->get('title'));
    $article->setContent($request->request->get('content'));
    $app['dao.article']->save($article);

    $responseData = array(
        'id' => $article->getId(),
        'title' => $article->getTitle(),
        'content' => $article->getContent()
    );
    return $app->json($responseData, 200);
});


//Suppression d'article
$app->post('/admin/delete/{id}', function($id) use ($app) {
    $app['dao.article']->delete($id);

    return $app->json('No Content', 204);
});