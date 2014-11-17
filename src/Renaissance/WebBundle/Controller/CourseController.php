<?php

namespace Renaissance\WebBundle\Controller;
use Renaissance\WebBundle\Controller\BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Debug\Exception\ContextErrorException;
use Symfony\Component\HttpFoundation\Request;

class CourseController extends BaseController
{
    public function indexAction()
    {
        $courseREST=$this->get('courseREST');
        $systems=$courseREST->getAllSystems();
        $items=array();
        foreach ($systems as $key => $system) {
            $categories=$courseREST->getAllCategoriesBySysName($system);
            $item=array(
                'system'=>$system,
                'categories'=>$categories,
                );
            $items[]=$item;
        }
        $request=$this->getRequest();
        $page_no=$request->query->get('pageno');
        $course_sys=$request->query->get('system');
        $course_cate=$request->query->get('category');
        if($page_no==null)
            $page_no="1";
        if($page_no=="1")$hasprevPage=false;
        else $hasprevPage=true;
        $prev_page_no=$page_no-1;
        $next_page_no=$page_no+2;
        if($course_sys==null&&$course_cate==null)
        {
            //$course_sys="";
            //$course_cate="";
            $per_page=6;
            $cur_page=$courseREST->getPerPageCourses($per_page,$page_no);
            $per_page=3;
            $next_page=$courseREST->getPerPageCourses($per_page,$next_page_no);
        }
        else
        {
            $per_page=6;
            $cur_page=$courseREST->getPerPageCoursesBySysCate($course_sys,$course_cate,$per_page,$page_no);
            $per_page=3;
            $next_page=$courseREST->getPerPageCoursesBySysCate($course_sys,$course_cate,$per_page,$next_page_no);
        }
        if($cur_page == null){   
            $data=array(
                'page'=>array(),'courses'=>array(),'imgurls'=>array(),'items'=>$items,
                );
            return $this->render('RenaissanceWebBundle:Course:index.html.twig',$data);
        }

        $hasnextPage=!empty($next_page);
        $img_urls=array();
        foreach ($cur_page as $key => $value) {
            $course_cover = $courseREST->getCourseCoverById($value->id,"S");
            if(!$course_cover)
                $img_urls[]="";
            else
            {
                $img_urls[]=$course_cover->url; 
            }
            $page=array(
            'hasnextPage'=>$hasnextPage,
            'hasprevPage'=>$hasprevPage,            
            'currentPage'=>$page_no,
            'nextPage'=>$next_page_no,
            'prevPage'=>$prev_page_no,
            'system'=>$course_sys,
            'category'=>$course_cate
            );
            $data=array(
            'page'=>$page,'courses'=>$cur_page,'imgurls'=>$img_urls,'items'=>$items,
            );
        }
        return $this->render('RenaissanceWebBundle:Course:index.html.twig',$data);    
    }
    public function showAction($course_id)
    {
            $courseREST = $this->get('courseREST');
            $course = $courseREST->getCourseById($course_id);
            if($course == null)
                   return $this->render('RenaissanceWebBundle:Error:404.html.twig', array("error_msg"=>"无此课程"));
            
            $isVisiable = $courseREST->getCourseStartState($course);
            $start_end = $courseREST->getCourseStartEnd($course);

            if(!empty($this->getUser())){
                $canvas_user_id = $this->getUser()->getCanvasUserId();
                $dbconn = $this->getCanvasConn();
                        $sql ="SELECT password_salt from pseudonyms where user_id=".$canvas_user_id;
                        if($dbconn){
                                $result = pg_query($dbconn,$sql);
                                if(!empty($result)){
                                    $salt = pg_fetch_array($result,0);
                                    pg_close($dbconn);
                                }else{
                                    return $this->render('RenaissanceWebBundle:Error:404.html.twig', array("error_msg"=>"信息有误"));
                                }
                        }else{
                                return $this->render('RenaissanceWebBundle:Error:404.html.twig', array("error_msg"=>"系统出错"));
                        }
            }else{
                $canvas_user_id = null;
                $salt = null;
            }
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
            if(empty($cover)){
                 return $this->render('RenaissanceWebBundle:Error:404.html.twig', array("error_msg"=>"课程正在编辑中"));
             }
            $chapters = $courseREST->getChapters($course_id);
            $course_info = $courseREST->getCourseInfo($course_id);
            $userREST = $this->get("userREST");
            $students = $userREST->getCourseStudents($course_id);
            $teachers = $userREST->getCourseTeachers($course_id);

            $head_urls=array();
            foreach ($teachers as $key => $value) {
                $profile = $userREST->getUserProfile($value->id);
                $teacher_avatar_url=$profile->avatar_url;
                $head_urls[] = $teacher_avatar_url;
            }
            $site_url =  $this->container->getParameter('site_url');
            //设置课程信息
            if( empty($course_info['课程介绍']) )
                $course_info['课程介绍'] = '暂无介绍';
            if( empty($course_info['所属课程体系']) ){
                $course_info['所属课程体系'] = '其他';
                $course_info['所属体系分类'] = '全部'; 
            }       
            elseif( empty($course_info['所属体系分类']) )
                $course_info['所属体系分类'] = '其他';        
            $data=array('course'=>$course,'students'=>$students,'teachers'=>$teachers, 'course_info'=>$course_info,
                'heads'=>$head_urls,'cover'=>$cover,'chapters'=>$chapters,'start_end'=>$start_end,
                'isEnrolled'=>$isEnrolled,'site_url'=>$site_url,'course_id'=>$course_id,'canvas_user_id'=>$canvas_user_id,
                'isVisiable'=>$isVisiable,'salt'=>$salt[0]);
             return $this->render('RenaissanceWebBundle:Course:show.html.twig', $data); 
    }
    public function showMoreAction(){
        $request=$this->getRequest();
        $courses=$request->get('object');
        $page_no=$request->query->get('pageno');
        $course_sys=$request->query->get('system');
        $course_cate=$request->query->get('category');
        $courseREST=$this->get('courseREST');
        //var_dump($course_sys);
        if($page_no=="")
            $page_no="1";
        if($page_no=="1")$hasprevPage=false;
        else $hasprevPage=true;
        $prev_page_no=$page_no-1;
        $next_page_no=$page_no+1;
        $per_page=3;
        if($course_sys==null&&$course_cate==null)
        {
            //$course_sys="";
            //$course_cate="";
            $cur_page=$courseREST->getPerPageCourses($per_page,$page_no);
            $next_page=$courseREST->getPerPageCourses($per_page,$next_page_no);
        }
        else
        {
            $cur_page=$courseREST->getPerPageCoursesBySysCate($course_sys,$course_cate,$per_page,$page_no);
            $next_page=$courseREST->getPerPageCoursesBySysCate($course_sys,$course_cate,$per_page,$next_page_no);
        }
        $hasnextPage=!empty($next_page);
        $img_urls=array();
        foreach ($cur_page as $key => $value) {
            $course_cover = $courseREST->getCourseCoverById($value->id,"S");
            if(!$course_cover)
                $img_urls[]="";
            else
            {
                $img_urls[]=$course_cover->url; 
            }
        }
            $page=array(
            'hasnextPage'=>$hasnextPage,
            'hasprevPage'=>$hasprevPage,            
            'currentPage'=>$page_no,
            'nextPage'=>$next_page_no,
            'prevPage'=>$prev_page_no,
            //'system'=>$course_sys,
            //'category'=>$course_cate
            );
        $data=array(
            'page'=>$page,'courses'=>$cur_page,'imgurls'=>$img_urls
            );
        return $this->render("RenaissanceWebBundle:Course:plaza_more.html.twig",$data);
    }

    
    //加入课程
    public function enrollAction(Request $request)
    {
        $course_id = $request->request->get('course_id');
        $user_id = $request->request->get('user_id');
        $salt = $request->request->get('salt');
        $json_data = null;
        $json_status = 0;
        $json_message = "加入课程失败";
        if (!empty($course_id)&&!empty($user_id)&&!empty($salt)) {
            $enrollmentREST = $this->get("enrollmentREST");
            $enrollmentREST->enrollAStudentToCourse($course_id,$user_id);
            $tokenREST = $this->get("tokenREST");
            $token = $tokenREST->getToken($course_id,$user_id,$salt);
            $res = $tokenREST->saveToken($token);
            if($res){
                $json_status = 1;
            }
            else{
                $json_status = 0;
                $json_message = '加入课程失败';
            }
        }
        return $this->createJsonResponse($json_data,$json_status,$json_message);  

        
    }

}
