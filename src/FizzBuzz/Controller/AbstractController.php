<?php

namespace FizzBuzz\Controller;

use FizzBuzz\Renderer;
use Smrtr\SpawnPoint\AbstractController as SpawnAbstractController;

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

    protected function renderMenu()
    {
        $sectionsRepository  = $this->app->container->get('SectionsRepository');
        $this->tpl->allSectionsForMenu = $sectionsRepository->findAll();
        echo $this->tpl->render('inc/menu.phtml');
        unset ($this->tpl->allSectionsForMenu);
    }
}
