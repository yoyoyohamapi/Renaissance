<?php

namespace Renaissance\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends BaseController
{

    public function indexAction()
    {	

            return $this->render('RenaissanceWebBundle:Default:index.html.twig');
    }

}
