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
    $output = '';
    foreach($articles as $post){
        $output .= $post->getTitle();
        $output .= '<br />';
    }

    return $output;
});

// Affichage d'un seul article
$app->get('/blog/{id}', function ($id) use ($app) {

    $article = $app['dao.article']->findOne($id);
    if (!isset($article)) {
        $app->abort(404, "L'article que vous recherchez n'existe pas.");
    }

    return "<h1>{$article->getTitle()}</h1>"."<p>{$article->getContent()}</p>";
});


// Back-office

// Création d'article
$app->post('/admin/create', function(Request $request) use ($app) {

    $article = new Article();

    $form = $app['form.factory']->create(new ArticleType(), $article);
    $form->handleRequest($request);

    if ($form->isValid() && $form->isSubmitted()) {
        $app['dao.article']->save($article);
        $message = "L'article a bien été créé !";
        $app['session']->getFlashBag()->add('success', $message);

    }

    $data = array(
        'form' => $form->createView(),
        'title' => "Ecrire un nouvel article",
    );

    return $app['twig']->render('create.html.twig', $data);

});


// Modification d'article
$app->post('/admin/update/{id}', function(Request $request, $id) use($app) {

    $article = $app['dao.article']->findOne($id);

    $form = $app['form.factory']->create(new ArticleType(), $article);
    $form->handleRequest($request);

    if ($form->isValid() && $form->isSubmitted()) {
        $app['dao.article']->save($article);
        $message = "L'article a bien été modifié !";
        $app['session']->getFlashBag()->add('success', $message);

    }

    $data = array(
        'form' => $form->createView(),
        'title' => "Modifier un article",
    );

    return $app['twig']->render('update.html.twig', $data);

});


//Suppression d'article
$app->post('/admin/delete/{id}', function($id) use ($app) {
    $app['dao.article']->delete($id);

    return "L'article a bien été supprimé !";
});