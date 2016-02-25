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

    protected function initDefaultTemplateVars()
    {
        $this->tpl->global = new \stdClass();

        $sectionRepository = $this->app->container->get('SectionsRepository');
        $sections = $sectionRepository->findAll();
        $this->tpl->global->sections = $sections;
    }
}
