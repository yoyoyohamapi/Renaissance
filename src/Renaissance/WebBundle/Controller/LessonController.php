<?php

namespace Renaissance\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LessonController extends Controller
{
    public function showAction($course_id,$lesson_id)
    {
        return $this->render('RenaissanceWebBundle:Lesson:show.html.twig', array(
                // ...
            ));    }

}
