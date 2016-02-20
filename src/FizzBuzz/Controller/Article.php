<?php

namespace FizzBuzz\Controller;

class Article extends AbstractController
{
    public function view()
    {
        $articleID = (int) $this->getRoutedParam('id');
        if (!$articleID) {
            throw new \Exception("Article ID is invalid", 404);
        }

        $articlesRepository = $this->app->container->get('ArticlesRepository');
        $article = $articlesRepository->findById($articleID);

        if (!is_array($article) or !count($article)) {
            throw new \Exception("Article not found", 404);
        }

        $this->renderMenu();

        $slug = str_replace(["\\", "'"], ["\\\\", "\\'"], $article['slug']);
        $this->tpl->requestPath = "/read/$articleID-$slug";
        $this->tpl->article = $article;
        echo $this->tpl->render('article/view.phtml');
    }
}
