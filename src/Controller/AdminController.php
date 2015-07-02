<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 02/07/15
 * Time: 10:14
 */

namespace Silex\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use SilexBlog\Entity\Article;

class AdminController
{
    public function createAction(Request $request, Application $app)
    {
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
    }

    public function updateAction($id, Request $request, Application $app)
    {
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
    }

    public function deleteAction($id, Application $app)
    {
        $app['dao.article']->delete($id);

        return $app->json('No Content', 204);
    }
}