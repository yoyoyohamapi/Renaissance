<?php

namespace Renaissance\WebBundle\Controller;
use Renaissance\WebBundle\Controller\BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

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
        if($cur_page == null){   
        $data=array(
            'page'=>array(),'courses'=>array(),'imgurls'=>array()
            );
        return $this->render('RenaissanceWebBundle:Course:index.html.twig',$data);
        }
        $next_page=$curlHelper->curlGet($api."?per_page=3&page=".$next_pageNo);
        $hasnextPage=!empty($next_page);
        $img_urls=array();
        foreach ($cur_page as $key => $value) {
            $folders=$curlHelper->curlGet($api."/".$value->id."/folders/by_path/cover");
            if(!$folders)
                $img_urls[]="";
            else
            {
              $cover_folder_id = $folders[count($folders)-1]->id;
              $course_img = $curlHelper->curlGet('folders/'.$cover_folder_id.'/files?search_term=S.png');
              if(!$course_img)
                 $img_urls[]="";
             else $img_urls[]=$course_img[0]->url; 
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
<<<<<<< HEAD
        $start_at = $course->start_at;
        $start_time = substr($start_at, 2,8);
        $time = time();
        $time = date("y-m-d",$time);
        
        $start_time = strtotime($start_time);
        $time = strtotime($time);
        //echo $start_time;
        //echo $time;

        if($start_time <= $time)
        {
            $isStart = true;
        }else{
            $isStart = false;
        }
        //echo $isDisable;

        $start_at_month = substr($start_at,5,2);
        $start_at_day = substr($start_at, 8,2);
        $start_at = $start_at_month.'月'.$start_at_day.'日';

        $end_at = $course->end_at;
        $end_at_month = substr($end_at,5,2);
        $end_at_day = substr($end_at, 8,2);
        $end_at = $end_at_month.'月'.$end_at_day.'日';
      
        $start_end =  array('start_at' =>$start_at ,'end_at'=>$end_at );

=======
>>>>>>> 189107666f10fa473b9d4e0aa0bc9a27baaf52c0
        $page=$curlHelper->curlGet($api."/front_page");
        $students=$curlHelper->curlGet($api."/users?enrollment_type=student");
        $teachers=$curlHelper->curlGet($api."/users?enrollment_type=teacher");
        $folders=$curlHelper->curlGet($api."/folders/by_path/cover");
<<<<<<< HEAD
    
        //var_dump($teachers);
        $canvas_user_id = $this->getUser()->getCanvasUserId();
        

        $stu_avatar = $curlHelper->curlGet("users/".$canvas_user_id."/profile");
        if($stu_avatar==NULL)
            $stu_avatar_url = NULL;
        else
            $stu_avatar_url = $stu_avatar->avatar_url;

        $enrollment = $curlHelper->curlGet($api."/enrollments?user_id=".$canvas_user_id);
        
        if(count($enrollment) == 0)
        {
            $isEnrolled = false;
        }else{
            $isEnrolled = true;
        }

        if($folders)
       {
=======
        if($folders)
        {
>>>>>>> 189107666f10fa473b9d4e0aa0bc9a27baaf52c0
            $cover_folder_id = $folders[count($folders)-1]->id;
            $fileimgs = $curlHelper->curlGet('folders/'.$cover_folder_id.'/files?search_term=L.png');
        }
        else $fileimgs=null;
        $chapters=$curlHelper->curlGet($api."/modules?include[]=items");
<<<<<<< HEAD
        //var_dump($chapters);
=======
>>>>>>> 189107666f10fa473b9d4e0aa0bc9a27baaf52c0
        if(!$page  || !$teachers || !$fileimgs || !$chapters)
            return $this->render('RenaissanceWebBundle:Error:404.html.twig', array("error_msg"=>"课程正在编辑中"));
        $head_urls=array();
        foreach ($teachers as $key => $value) {
            $profile=$curlHelper->curlGet("users/".$value->id."/profile");
            $head_urls[]=$profile->avatar_url;
        }
        $cover=$fileimgs[0]->url;
        $page->body=substr($page->body, 3,-4);
<<<<<<< HEAD

        $site_url =  $this->container->getParameter('site_url');

        $data=array('course'=>$course,'students'=>$students,'teachers'=>$teachers,
            'page'=>$page,'heads'=>$head_urls,'cover'=>$cover,'chapters'=>$chapters,'start_end'=>$start_end,
            'isEnrolled'=>$isEnrolled,'site_url'=>$site_url,'course_id'=>$course_id,'canvas_user_id'=>$canvas_user_id,'isStart'=>$isStart,
            'stu_avatar_url'=>$stu_avatar_url);
         return $this->render('RenaissanceWebBundle:Course:show.html.twig', $data); 
=======
        $data=array('course'=>$course,'students'=>$students,'teachers'=>$teachers,
            'page'=>$page,'heads'=>$head_urls,'cover'=>$cover,'chapters'=>$chapters);
        return $this->render('RenaissanceWebBundle:Course:show.html.twig', $data);    
>>>>>>> 189107666f10fa473b9d4e0aa0bc9a27baaf52c0
    }
    public function ajaxAction(){

    }
<<<<<<< HEAD

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
            $folders=$curlHelper->curlGet($api."/".$value->id."/folders/by_path/cover");
            if(!$folders)
                $img_urls[]="";
            else
            {
              $cover_folder_id = $folders[count($folders)-1]->id;
              $course_img = $curlHelper->curlGet('folders/'.$cover_folder_id.'/files?search_term=S.png');
              if(!$course_img)
                 $img_urls[]="";
             else $img_urls[]=$course_img[0]->url; 
            }
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
=======
>>>>>>> 189107666f10fa473b9d4e0aa0bc9a27baaf52c0

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
            $folders=$curlHelper->curlGet($api."/".$value->id."/folders/by_path/cover");
            if(!$folders)
                $img_urls[]="";
            else
            {
              $cover_folder_id = $folders[count($folders)-1]->id;
              $course_img = $curlHelper->curlGet('folders/'.$cover_folder_id.'/files?search_term=S.png');
              if(!$course_img)
                 $img_urls[]="";
             else $img_urls[]=$course_img[0]->url; 
            }
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
