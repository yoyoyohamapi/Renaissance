<?php

namespace Renaissance\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CourseController extends Controller
{
    public function indexAction()
    {
        return $this->render('RenaissanceWebBundle:Course:index.html.twig', array(
                // ...
            ));    }

    public function showAction($course_id)
    {
        return $this->render('RenaissanceWebBundle:Course:show.html.twig', array(
                // ...
            ));    }

}
