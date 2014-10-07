<?php

namespace Renaissance\WebBundle\Controller;
use Renaissance\WebBundle\Controller\BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CourseController extends BaseController
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
        $nextpgno=$pageno+2;
        //$stastic=$curlHelper->curlGet('courses/2/analytics/activity ');
        $curCsPage=$curlHelper->curlGet($api."?per_page=6&page=".$pageno);
        $nextCsPage=$curlHelper->curlGet($api."?per_page=3&page=".$nextpgno);
        $hasnextPage=!empty($nextCsPage);
        //var_dump($stastic);
        //exit();
        $imgurls=array();
        foreach ($curCsPage as $key => $value) {
            $courseimg=$curlHelper->curlGet($api."/".$value->id."/files?search_term=cover");
            //var_dump($courseimg[0]->url);
            $imgurls[]=$courseimg[0]->url; 
                    // exit();
        }
        $page=array(
            'hasnextPage'=>$hasnextPage,
            'hasprevPage'=>$hasprevPage,
            'currentPage'=>$pageno,
            'nextPage'=>$nextpgno,
            'prevPage'=>$prevpgno
            );

        $data=array(
            'page'=>$page,'courses'=>$curCsPage,'imgurls'=>$imgurls
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
        $fileimgs=$curlHelper->curlGet($api."/files?search_term=cover");
        $head_urls=array();
        foreach ($teachers as $key => $value) {
            $profile=$curlHelper->curlGet("users/".$value->id."/profile");
            $head_urls[]=$profile->avatar_url;
        }
        $cover=$fileimgs[0]->url;
        $page->body=substr($page->body, 3,-4);
        //exit();
        $data=array('course'=>$course,'students'=>$students,'teachers'=>$teachers,
            'page'=>$page,'heads'=>$head_urls,'cover'=>$cover);
        return $this->render('RenaissanceWebBundle:Course:show.html.twig', $data);    
    }
    public function ajaxAction(){

    }

    public function showMoreAction(){
        //return $this->createJsonResponse(array("ooo"=>"1111"));
        $request=$this->getRequest();
        $courses=$request->get('object');
        $pageno=$request->query->get('pageno');
        $curlHelper=$this->get('curlHelper');
        $api=$courses;
        //$courses=$curlHelper->curlGet($api.'?include[]=syllabus_body');
        if($pageno=="")
            $pageno="1";
        if($pageno=="1")$hasprevPage=false;
        else $hasprevPage=true;
        $prevpgno=$pageno-1;
        $nextpgno=$pageno+1;
        //$stastic=$curlHelper->curlGet('courses/2/analytics/activity ');
        $curCsPage=$curlHelper->curlGet($api."?per_page=3&page=".$pageno);
        $nextCsPage=$curlHelper->curlGet($api."?per_page=3&page=".$nextpgno);
        $hasnextPage=!empty($nextCsPage);
        //var_dump($stastic);
        //exit();
        $imgurls=array();
        foreach ($curCsPage as $key => $value) {
            $courseimg=$curlHelper->curlGet($api."/".$value->id."/files?search_term=cover");
            //var_dump($courseimg[0]->url);
            $imgurls[]=$courseimg[0]->url; 
                    // exit();
        }
         $page=array(
            'hasnextPage'=>$hasnextPage,
            'hasprevPage'=>$hasprevPage,
            'currentPage'=>$pageno,
            'nextPage'=>$nextpgno,
            'prevPage'=>$prevpgno
            );
        $data=array(
            'page'=>$page,'courses'=>$curCsPage,'imgurls'=>$imgurls
            );
        //var_dump($curCsPage);
        //exit();
        return $this->render("RenaissanceWebBundle:Course:plaza_more.html.twig",$data);
    }

}
