<?php

namespace Renaissance\WebBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Renaissance\WebBundle\Controller\BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class EnrollController extends BaseController
{
    public function enrollAction(Request $request)
    {
    	$course_id = $request->request->get('course_id');
	$user_id = $request->request->get('user_id');
             $alt = $request->request->get('alt');
	$curlHelper = $this->get('curlHelper');

        	$api = "courses/".$course_id."/enrollments";
        	$enrollment['user_id'] = $user_id;
        	$enrollment['type'] = "StudentEnrollment";
        	$post_field = array("enrollment" => $enrollment,);
        	$user_new = $curlHelper->curlCustom($api,$post_field,'POST');

        	if(!empty($user_new->id)){
        		return $this->createJsonResponse(array("enroll"=>"success"));
        	}else {
		return $this->render('RenaissanceWebBundle:Course:show.html.twig',array("error"=>"注册失败"));
	}  	
    }

    public function getToken($course_id,$user_id,$alt){
        $str = $user_id.$course_id.$alt;
        $token = sha1($str);
        $token = $token.$course_id.$alt;
        return $token;
    }
}