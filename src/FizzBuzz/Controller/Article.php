<?php

namespace FizzBuzz\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse as RedirectResponse;

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

        if ($article['slug'] !== $this->getRoutedParam('slug')) {
            $redirectParams = array(
                'id' => $article['id'],
                'slug' => $article['slug']
            );
            return (new RedirectResponse($this->app->router->generate('article-view', $redirectParams)))->send();
        }

        $this->tpl->article = $article;
        echo $this->tpl->render('article/view.phtml');
    }
}
