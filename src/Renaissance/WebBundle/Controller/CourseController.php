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
        $pageNo=$request->query->get('pageno');
        if($pageNo==null)
            $pageNo="1";
        if($pageNo=="1")$hasprevPage=false;
        else $hasprevPage=true;
        $prev_pageNo=$pageNo-1;
        $next_pageNo=$pageNo+2;
        $cur_page=$curlHelper->curlGet($api."?per_page=6&page=".$pageNo);
        if($cur_page){   
        $data=array(
            'page'=>array(),'courses'=>array(),'imgurls'=>array()
            );
        return $this->render('RenaissanceWebBundle:Course:index.html.twig',$data);
        }
        $next_page=$curlHelper->curlGet($api."?per_page=3&page=".$next_pageNo);
        $hasnextPage=!empty($next_page);
        $img_urls=array();
        foreach ($cur_page as $key => $value) {
            $course_img=$curlHelper->curlGet($api."/".$value->id."/files?search_term=cover");
             if(!$course_img)
                $img_urls[]="";
            $img_urls[]=$course_img[0]->url; 
            $page=array(
            'hasnextPage'=>$hasnextPage,
            'hasprevPage'=>$hasprevPage,
            'currentPage'=>$pageNo,
            'nextPage'=>$next_pageNo,
            'prevPage'=>$prev_pageNo
            );
            $data=array(
            'page'=>$page,'courses'=>$cur_page,'imgurls'=>$img_urls
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
        $pageNo=$request->query->get('pageno');
        $curlHelper=$this->get('curlHelper');
        $api=$courses;
        if($pageNo=="")
            $pageNo="1";
        if($pageNo=="1")$hasprevPage=false;
        else $hasprevPage=true;
        $prev_pageNo=$pageNo-1;
        $next_pageNo=$pageNo+1;
        $cur_page=$curlHelper->curlGet($api."?per_page=3&page=".$pageNo);
        $next_page=$curlHelper->curlGet($api."?per_page=3&page=".$next_pageNo);
        $hasnextPage=!empty($next_page);
        $img_urls=array();
        foreach ($cur_page as $key => $value) {
            $course_img=$curlHelper->curlGet($api."/".$value->id."/files?search_term=cover");
            if(!$course_img)
                $img_urls[]="";
            $img_urls[]=$course_img[0]->url; 
        }
         $page=array(
            'hasnextPage'=>$hasnextPage,
            'hasprevPage'=>$hasprevPage,
            'currentPage'=>$pageNo,
            'nextPage'=>$next_pageNo,
            'prevPage'=>$prev_pageNo
            );
        $data=array(
            'page'=>$page,'courses'=>$cur_page,'imgurls'=>$img_urls
            );
        return $this->render("RenaissanceWebBundle:Course:plaza_more.html.twig",$data);
    }
}
