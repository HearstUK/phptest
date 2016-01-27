<?php

namespace FizzBuzz\Controller;

class Article extends AbstractController
{
    public function view()
    {
        $articleID = (int) $this->getRoutedParam('id');
        $slug = $this->getRoutedParam('slug');

        if (!$articleID) {
            throw new \Exception("Article ID is invalid", 404);
        }

        $articlesRepository = $this->app->container->get('ArticlesRepository');
        $article = $articlesRepository->findById($articleID);

        if (!is_array($article) or !count($article)) {
            throw new \Exception("Article not found", 404);
        }

        if ($article['slug'] !== $slug) {
            $this->redirectToRoute('article-view', ['id' => $articleID, 'slug' => $article['slug']]);
        }

        $this->tpl->article = $article;
        $this->render('article/view.phtml');
    }
}
