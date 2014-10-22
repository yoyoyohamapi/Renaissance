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
}