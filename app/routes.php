<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 01/07/15
 * Time: 14:58
 */

use Symfony\Component\HttpFoundation\Request;

$app->get('/blog', function () use ($app) {

    $articles = $app['dao.article']->findAll();
    $output = '';
    foreach($articles as $post){
        $output .= $post->getTitle();
        $output .= '<br />';
    }

    return $output;
});

$app->get('/blog/{id}', function ($id) use ($app) {

    $article = $app['dao.article']->findOne($id);
    if (!isset($article)) {
        $app->abort(404, "L'article que vous recherchez n'existe pas.");
    }

    return "<h1>{$article->getTitle()}</h1>"."<p>{$article->getContent()}</p>";
});

$app->post('/admin/create', function(Request $request) use ($app) {

    $article = new Article();

    $form = $app['form.factory']->createBuilder('form', $article)
        ->add('title', 'text')
        ->add('content', 'textarea')
        ->add('save', 'submit')
        ->getForm();

    $form->handleRequest($request);
    if ($form->isValid()) {
        $app['repository.article']->save($article);
        $message = "L'article a bien été créé !";
        $app['session']->getFlashBag()->add('success', $message);

    }

    $data = array(
        'form' => $form->createView(),
        'title' => "Ecrire un nouvel article",
    );

    return $app['twig']->render('create.html.twig', $data);

});

$app->post('/admin/update/{article}', function(Request $request, Article $article) use($app) {

    $form = $app['form.factory']->createBuilder('form', $article)
        ->add('title', 'text')
        ->add('content', 'textarea')
        ->add('save', 'submit')
        ->getForm();

    $form->handleRequest($request);
    if ($form->isValid()) {
        $app['repository.article']->save($article);
        $message = "L'article a bien été modifié !";
        $app['session']->getFlashBag()->add('success', $message);

    }

    $data = array(
        'form' => $form->createView(),
        'title' => "Modifier un article",
    );

    return $app['twig']->render('update.html.twig', $data);

})->convert('article', 'converter.article:convert');

$app->post('/admin/delete/{article}', function(Request $request, Article $article) {

    return "L'article a bien été supprimé !";
})->convert('article', 'converter.article:convert');