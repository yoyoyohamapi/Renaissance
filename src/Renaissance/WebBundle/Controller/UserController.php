<?php

namespace Renaissance\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction($user_id)
    {
        return $this->render('RenaissanceWebBundle:User:index.html.twig', array(
                // ...
            ));    }

}
