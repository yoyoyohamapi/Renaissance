<?php
namespace Renaissance\CommonBundle\REST\Canvas;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Debug\Exception\ContextErrorException;


class CourseREST extends CanvasBaseREST{

	public function getAllCourses(){
		$this->api="courses";
		$courses = $this->execute();
		return $courses;
	}

	public function getCoursesForCurrentUser($id){
		$enrollmentREST = $this->container->get('enrollmentREST');
		$enrollments = $enrollmentREST->getAllEnrollmentsByUserId($id);
		if( !empty($enrollments) ){
			$courses = array();
			foreach ($enrollments as $enrollment ) {
				$courses[] = $this->getCourseById($enrollment->course_id);
			};
			return $courses;
		}
		return null;
	}

	public function getCurrentCourse($user_id){
		$enrollmentREST = $this->container->get('enrollmentREST');
		$current_errollment = $enrollmentREST->getCurrentEnrollment($user_id);
		if( !empty($current_errollment) )
			return $this->getCourseById($current_errollment->course_id);
		return null;
	}

	public function getCourseById($id){
		$this->api = "courses/".$id;
		$course = $this->execute();
		return $course;
	}

	public function getCourseCoverById($id,$size){
		$fileREST = $this->container->get('fileREST');
		$size = strtoupper($size);
		$covers = $fileREST->getFileByPath('course',$id,'cover/'.$size.'.png');
		if( !empty($covers) )
			$cover = $covers[0];
		else 
			$cover = null;
		return $cover;
	}
	//获取课程状态
	public function getCourseStartState($course){
		$start_at = $course->start_at;
		$end_at = $course->end_at;
		if(!empty($start_at) && !empty($end_at)){
			$start_time = substr($start_at, 2, 8);
			$end_time = substr($end_at, 2, 8);
			$time = time();
	       		$time = date("y-m-d",$time);
	        		
	        		$start_time = strtotime($start_time);
	        		$end_time = strtotime($end_time);
	        		$time = strtotime($time);

	        		if(($time >= $start_time) && ($time <= $end_time)){
	        			$isVisiable = true;
	        		}else{
	        			$isVisiable = false;
	        		}	
		}elseif (!empty($start_at) && empty($end_at)) {
			$start_time = substr($start_at, 2, 8);
			$time = time();
	       		$time = date("y-m-d",$time);

	       		$start_time = strtotime($start_time);
	       		$time = strtotime($time);
	       		if ($start_time <= $time) {
	       			$isVisiable = true;
	       		}else{
	       			$isVisiable = false;
	       		}
		}else{
			$isVisiable = false;
		}
		return $isVisiable;
	}
	public function getCourseStartEnd($course){
		$start_at = $course->start_at;
		$end_at = $course->end_at;
		if(!empty($start_at) && !empty($end_at)){
			$start_time = substr($start_at, 2,8);
	        		$start_at_month = substr($start_at,5,2);
        			$start_at_day = substr($start_at, 8,2);
        			$start_at = $start_at_month.'月'.$start_at_day.'日';
        			$end_at_month = substr($end_at,5,2);
        			$end_at_day = substr($end_at, 8,2);
        			$end_at = $end_at_month.'月'.$end_at_day.'日';
      
        			$start_end =  array('start_at' =>$start_at.'---','end_at'=>$end_at );
		}elseif(!empty($start_at) && empty($end_at)){
			$start_time = substr($start_at, 2,8);
	        		$start_at_month = substr($start_at,5,2);
        			$start_at_day = substr($start_at, 8,2);
        			$start_at = $start_at_month.'月'.$start_at_day.'日';
        			$start_end =  array('start_at' =>$start_at.'---', 'end_at'=>"结束时间未知" );
		}else{
			$start_end = array('start_at' => "课程尚未开始", 'end_at'=>"");
		}
		return $start_end;
	}
	public function getCoursePage($course_id){
		$pageRest = $this->container->get("pageRest");
		return $pageRest->getPageByCourseId($course_id);
	}
	
	public function getChapters($course_id){
		$modulesREST = $this->container->get("modulesREST");
		return $modulesREST->getModulesByCourseId($course_id);
	}

	//根据课程号获得课程信息
	public function getCourseInfo($course_id){
		$crawler = new Crawler();
		$course_info = array();
		$page = $this->getCoursePage($course_id);
		try{
			$page_html = $page->body;
			$crawler->addHTMLContent($page_html,'UTF-8');
			$lis = $crawler->filter('li');
			foreach( $lis as $li ){
				$info = split(':',$li->nodeValue);
				$course_info[$info[0]] = $info[1];
			}
		}catch(ContextErrorException $e){
			return null;
		}
		return $course_info;
	}

	//获得所有课程体系
	public function getAllSystems(){
		$systems = array();
		//获得所有课程 
		$courses = $this->getAllCourses();
		//遍历课程取得分类
		foreach ($courses as $course){
			$course_info = $this->getCourseInfo($course->id);
			$system =  $course_info['所属课程体系'];
			if($system)
				$systems[] = $sys;
		}
		$systems[] = "其他";
		return $systems;
	}

	//根据体系名字获得某体系下分类
	public function getAllCategoriesBySysName($sys_name){
		$categories = array();
		//获得所有课程
		$courses = $this->getAllCourses();
		//遍历课程获得分类
		foreach($courses as $course){
			$course_info = $this->getCourseInfo($course->id);
			$system =  $course_info['所属课程体系'];
			$category = $course_info['所属体系分类'];
			if($category){
				if( ($system == $sys_name) || ($sys_name == '其他' && !$system) ) 
					$categories[] = $category;
			}
		}
		return $categories;
	}

	//根据体系名，分类名获得对应所有课程
	public function getCoursesBySysCate($sys_name,$cate_name){
		$courses = array();
		$courses_all = $this->getAllCourses();
		foreach($courses_all as $crs){
			$crs_info = $this->getCourseInfo($crs->id);
			$system =  $crs_info['所属课程体系'];
			$category = $crs_info['所属体系分类'];
			//如果课程体系，体系分类都已录入
			if( $system && $category){
				if( $sys_name==$system && $category==$cate_name )
					$courses[] = $crs;
			}else if( !$system && $sys_name=='其他'){
				//如果体系为'其他',分类为'其他'
				if( (!$category && $cate_name=='全部') || $category==$cate_name )
					$courses[] = $crs;  
			}
		}
		return $courses;
	}
}