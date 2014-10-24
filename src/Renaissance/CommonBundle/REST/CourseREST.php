<?php
namespace Renaissance\CommonBundle\REST;
use Renaissance\CommonBundle\REST\REST_Base;

class CourseREST extends BaseREST{

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
	public function getCourseStartState($course){
		$start_at = $course->start_at;
		if(!empty($start_at)){
			$start_time = substr($start_at, 2,8);
			$time = time();
	       		$time = date("y-m-d",$time);
	        
	        		$start_time = strtotime($start_time);
	        		$time = strtotime($time);

	        		if($start_time <= $time)
	        		{
	           			$isStart = true;
	        		}else{
	            			$isStart = false;
	        		}
	        		
		}else{
			$isStart = false;
		}
		return $isStart;
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
}