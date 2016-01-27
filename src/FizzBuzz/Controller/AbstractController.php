<?php

namespace FizzBuzz\Controller;

use FizzBuzz\Renderer;
use Smrtr\SpawnPoint\AbstractController as SpawnAbstractController;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController extends SpawnAbstractController
{
    /**
     * @var \FizzBuzz\Renderer
     */
    protected $tpl;

    public function __construct()
    {
        $this->tpl = new Renderer;
    }

    /**
     * Redirects to a specific route
     *
     * @param string $route
     * @param array $params
     * @param int $status
     * @throws \Smrtr\HaltoRouterException
     */
    protected function redirectToRoute($route, $params = [], $status = Response::HTTP_FOUND)
    {
        $url = $this->app->router->generate($route, $params);
        $this->redirect($url, $status);
    }

    /**
     * Redirects to given URL
     *
     * @param string $url
     * @param int $status
     */
    protected function redirect($url, $status = Response::HTTP_FOUND)
    {
        $location = $this->getRequest()->server->get('REQUEST_SCHEME') . ':' . $url;

        // ideally, we should just return an instance of \Symfony\Component\HttpFoundation\RedirectResponse
        // and \Smrtr\SpawnPoint\App should handle that and perform the redirection
        header('Location: ' . $location, true, $status);
        exit;
    }

    /**
     * Renders template
     *
     * @param $template
     * @throws \Exception
     */
    protected function render($template)
    {
        /** @var \FizzBuzz\Service\SectionsRepository $sectionsRepository */
        $sectionsRepository = $this->app->container->get('SectionsRepository');
        $this->tpl->sections = $sectionsRepository->findAll();

        $this->tpl->sectionUrl = function ($section) {
            $url = $this->app->router->generate('section', ['slug' => $section['slug']]);
            return $url;
        };

        echo $this->tpl->render($template);
    }
}
