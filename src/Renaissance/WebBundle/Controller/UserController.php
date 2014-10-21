<?php

namespace Renaissance\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction($user_id)
    {
    	$user = $this->getUser();
    	//Get user's current course
    	$courseREST = $this->get('courseREST');
    	$current_course = $courseREST->getCurrentCourse($user->getCanvasUserId());
    	$cover_size = 'L';
    	$current_course_cover = $courseREST->getCourseCoverById($current_course->id,$cover_size);
        	return $this->render('RenaissanceWebBundle:User:index.html.twig', array(
        		'current_course'=>$current_course,
        		'current_course_cover'=>$current_course_cover
	));    
    }

}
