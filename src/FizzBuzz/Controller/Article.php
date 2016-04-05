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

	// Check if article was loaded with correct slug; if not, redirect.
	$slug = $this->getRoutedParam('slug');
	if ($slug != $article['slug'])
	{
	    // No controller method for redirects, so hacky solution:
	    $slug = $article['slug'];
	    header("Location: $articleID-$slug");
	    exit;
	}

        $this->tpl->article = $article;
        echo $this->tpl->render('article/view.phtml');
    }
}
