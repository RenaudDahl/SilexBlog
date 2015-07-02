<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 02/07/15
 * Time: 10:09
 */

namespace Silex\Controller;

use Silex\Application;
use SilexBlog\Entity\Article;

class HomeController
{
    public function indexAction(Application $app)
    {
        $articles = $app['dao.article']->findAll();
        $output = array();
        foreach($articles as $post){
            $output[] = array(
                'id'    => $post->getId(),
                'titre' => $post->getTitle(),
            );
        }

        return $app->json($output);
    }

    public function articleAction($id, Application $app)
    {
        $article = $app['dao.article']->findOne($id);
        if (!isset($article)) {
            $app->abort(404, "L'article que vous recherchez n'existe pas.");
        }

        $output = array(
            'titre'   => $article->getTitle(),
            'contenu' => $article->getContent(),
        );

        return $app->json($output);
    }
}