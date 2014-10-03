<?php

namespace Renaissance\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CourseController extends Controller
{
    public function indexAction()
    {
        $curlHelper=$this->get('curlHelper');
        $api="courses";
        $courses=$curlHelper->curlGet($api);
        //var_dump($courses[0]->name);
        //exit();
        $data=array('courses'=>$courses);
        return $this->render('RenaissanceWebBundle:Course:index.html.twig',$data);    
    }

    public function showAction($course_id)
    {
        $curlHelper=$this->get('curlHelper');
        $api="courses/".$course_id;
        $request['enrollment_type']='teacher';
        $type='GET';
        //$course=$curlHelper->curlGet($api);
       // $page=$curlHelper->curlGet($api."/front_page");
        //$students=$curlHelper->curlGet($api."/students");
        $teachers=$curlHelper->curlGet($api."/users?enrollment_type=teacher");
        //$page->body=substr($page->body, 3,-4);
        var_dump($teachers);
        exit();
        $data=array('course'=>$course,'students'=>$students,'teachers'=>$teachers,'page'=>$page);
        return $this->render('RenaissanceWebBundle:Course:show.html.twig', $data);    
    }

}
