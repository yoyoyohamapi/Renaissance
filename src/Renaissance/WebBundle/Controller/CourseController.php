<?php

namespace Renaissance\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CourseController extends Controller
{
    public function indexAction()
    {
        $curlHelper=$this->get('curlHelper');
        $api="courses";
        //$courses=$curlHelper->curlGet($api.'?include[]=syllabus_body');
        $request=$this->getRequest();
        $pageno=$request->query->get('pageno');
        if($pageno=="")
            $pageno="1";
        if($pageno=="1")$hasprevPage=false;
        else $hasprevPage=true;
        $prevpgno=$pageno-1;
        $nextpgno=$pageno+1;
        $curCsPage=$curlHelper->curlGet($api."?per_page=2&page=".$pageno);
        $nextCsPage=$curlHelper->curlGet($api."?per_page=2&page=".$nextpgno);
        $hasnextPage=!empty($nextCsPage);
        //var_dump($hasprevPage);
        $page=array(
            'hasnextPage'=>$hasnextPage,
            'hasprevPage'=>$hasprevPage,
            'currentPage'=>$pageno,
            'nextPage'=>$nextpgno,
            'prevPage'=>$prevpgno
            );
        $data=array(
            'page'=>$page,'courses'=>$curCsPage
            );
        return $this->render('RenaissanceWebBundle:Course:index.html.twig',$data);    
    }

    public function showAction($course_id)
    {
        $curlHelper=$this->get('curlHelper');
        $api="courses/".$course_id;
        $course=$curlHelper->curlGet($api);        
        $page=$curlHelper->curlGet($api."/front_page");
        $students=$curlHelper->curlGet($api."/users?enrollment_type=student");
        $teachers=$curlHelper->curlGet($api."/users?enrollment_type=teacher");
        $head_urls=array();
        foreach ($teachers as $key => $value) {
            $profile=$curlHelper->curlGet("users/".$value->id."/profile");
            $head_urls[]=$profile->avatar_url;
        }
        $page->body=substr($page->body, 3,-4);
        //var_dump($head_urls[0]);
        //exit();
        $data=array('course'=>$course,'students'=>$students,'teachers'=>$teachers,'page'=>$page,'heads'=>$head_urls);
        return $this->render('RenaissanceWebBundle:Course:show.html.twig', $data);    
    }

}
