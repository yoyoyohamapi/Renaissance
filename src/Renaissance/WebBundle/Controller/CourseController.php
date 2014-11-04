<?php

namespace Renaissance\WebBundle\Controller;
use Renaissance\WebBundle\Controller\BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Debug\Exception\ContextErrorException;

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
        try{
        $courseREST = $this->get('courseREST');
        $course = $courseREST->getCourseById($course_id);
        if($course == null)
               return $this->render('RenaissanceWebBundle:Error:404.html.twig', array("error_msg"=>"无此课程"));

        $isStart = $courseREST->getCourseStartState($course);
        $start_end = $courseREST->getCourseStartEnd($course);

        if(!empty($this->getUser()))
            $canvas_user_id = $this->getUser()->getCanvasUserId();
        else
            $canvas_user_id = null;

        $enrollmentREST = $this->get("enrollmentREST");
        $enrollment = $enrollmentREST->getCourseEnrollmentByUserId($course_id, $canvas_user_id);
        
        if(count($enrollment) == 0)
        {
            $isEnrolled = false;
        }else{
            $isEnrolled = true;
        }

        $size = "L";
        $cover = $courseREST->getCourseCoverById($course_id,$size);

        $chapters = $courseREST->getChapters($course_id);
        $page = $courseREST->getCoursePage($course_id);
        
        $userREST = $this->get("userREST");
        $students = $userREST->getCourseStudents($course_id);
        $teachers = $userREST->getCourseTeachers($course_id);


        $head_urls=array();
        foreach ($teachers as $key => $value) {
            $profile = $userREST->getUserProfile($value->id);
            $teacher_avatar_url=$profile->avatar_url;
            $head_urls[] = $teacher_avatar_url;
        }

        $page->body=substr($page->body, 3,-4);

        $site_url =  $this->container->getParameter('site_url');

        $data=array('course'=>$course,'students'=>$students,'teachers'=>$teachers,
            'page'=>$page,'heads'=>$head_urls,'cover'=>$cover,'chapters'=>$chapters,'start_end'=>$start_end,
            'isEnrolled'=>$isEnrolled,'site_url'=>$site_url,'course_id'=>$course_id,'canvas_user_id'=>$canvas_user_id,'isStart'=>$isStart);
         return $this->render('RenaissanceWebBundle:Course:show.html.twig', $data); 
        }catch(ContextErrorException $e){
            return $this->render('RenaissanceWebBundle:Error:404.html.twig', array("error_msg"=>"课程正在编辑中"));

        }
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
