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
        $request=$this->getRequest();
        $pageno=$request->query->get('pageno');
        if($pageno == null)
            $data=array(
            'page'=>array(),'courses'=>array(),'imgurls'=>array()
            );
        else{
        if($pageno=="")
            $pageno="1";
        if($pageno=="1")$hasprevPage=false;
        else $hasprevPage=true;
        $prevpgno=$pageno-1;
        $nextpgno=$pageno+2;
        $curCsPage=$curlHelper->curlGet($api."?per_page=6&page=".$pageno);
        $nextCsPage=$curlHelper->curlGet($api."?per_page=3&page=".$nextpgno);
        $hasnextPage=!empty($nextCsPage);
        $imgurls=array();
        foreach ($curCsPage as $key => $value) {
            $courseimg=$curlHelper->curlGet($api."/".$value->id."/files?search_term=cover");
             if(!$courseimg)
                $imgurls[]="";
            $imgurls[]=$courseimg[0]->url; 
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
        }
        return $this->render('RenaissanceWebBundle:Course:index.html.twig',$data);    
    }

    public function showAction($course_id)
    {
        $curlHelper=$this->get('curlHelper');
        $api="courses/".$course_id;
        $course=$curlHelper->curlGet($api); 
        if($course == null)
               return $this->render('RenaissanceWebBundle:Error:404.html.twig', array("error_msg"=>"无此课程"));
        $page=$curlHelper->curlGet($api."/front_page");
        $students=$curlHelper->curlGet($api."/users?enrollment_type=student");
        $teachers=$curlHelper->curlGet($api."/users?enrollment_type=teacher");
        $fileimgs=$curlHelper->curlGet($api."/files?search_term=cover");
        $lessons=$curlHelper->curlGet($api."/modules?include[]=items");
        if(!$page || !$students || !$teachers || !$fileimgs || !$lessons)
            return $this->render('RenaissanceWebBundle:Error:404.html.twig', array("error_msg"=>"课程正在编辑中"));
        $head_urls=array();
        foreach ($teachers as $key => $value) {
            $profile=$curlHelper->curlGet("users/".$value->id."/profile");
            $head_urls[]=$profile->avatar_url;
        }
        $cover=$fileimgs[0]->url;
        $page->body=substr($page->body, 3,-4);
        $data=array('course'=>$course,'students'=>$students,'teachers'=>$teachers,
            'page'=>$page,'heads'=>$head_urls,'cover'=>$cover,"lessons"=>$lessons);
        return $this->render('RenaissanceWebBundle:Course:show.html.twig', $data);    
    }
    public function ajaxAction(){

    }

    public function showMoreAction(){
        $request=$this->getRequest();
        $courses=$request->get('object');
        $pageno=$request->query->get('pageno');
        $curlHelper=$this->get('curlHelper');
        $api=$courses;
        if($pageno=="")
            $pageno="1";
        if($pageno=="1")$hasprevPage=false;
        else $hasprevPage=true;
        $prevpgno=$pageno-1;
        $nextpgno=$pageno+1;
        $curCsPage=$curlHelper->curlGet($api."?per_page=3&page=".$pageno);
        $nextCsPage=$curlHelper->curlGet($api."?per_page=3&page=".$nextpgno);
        $hasnextPage=!empty($nextCsPage);
        $imgurls=array();
        foreach ($curCsPage as $key => $value) {
            $courseimg=$curlHelper->curlGet($api."/".$value->id."/files?search_term=cover");
            if(!$courseimg)
                $imgurls[]="";
            $imgurls[]=$courseimg[0]->url; 
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
        return $this->render("RenaissanceWebBundle:Course:plaza_more.html.twig",$data);
    }

}
