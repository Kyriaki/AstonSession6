<?php

namespace intro\CrudBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('introCrudBundle:Default:index.html.twig');
    }
}
