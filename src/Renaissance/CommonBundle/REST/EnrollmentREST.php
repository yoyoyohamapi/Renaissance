<?php
namespace Renaissance\CommonBundle\REST;
class EnrollmentREST extends BaseREST{
	public function getAllEnrollmentsByCourseId($id){
		$this->api = 'course/'.$id.'/enrollments';
		return $this->execute();
	}

	public function getAllEnrollmentsBySectionId($id){
		$this->api = 'sections/'.$id.'/enrollments';
		return $this->execute();
	}

	public function getAllEnrollmentsByUserId($id){
		$this->api = 'users/'.$id.'/enrollments';
		return $this->execute();
	}

	public function getCourseEnrollmentByUserId($course_id, $canvas_user_id){
		$this->api = "courses/".$course_id."/enrollments?user_id=".$canvas_user_id;
		$enrollment = $this->execute();
		return $enrollment;
	}
	
	public function getCurrentEnrollment($user_id){
		$enrollments = $this->getAllEnrollmentsByUserId($user_id);
		if( !empty($enrollments) ){
			$active_at_array = array_map(function($e){
				return $e->last_activity_at;
			},$enrollments);
			$key = array_search(max($active_at_array),$active_at_array);
			return $enrollments[$key];
		}
		return null;
	}

	public function enrollAStudentToCourse($course_id,$student_id){
		$this->api = 'courses/'.$course_id.'/enrollments';
		$this->enrollAStudent($student_id);
	}

	public function enrollAStudentToSection($section_id,$student_id){
		$this->api = 'sections/'.$section_id.'/enrollments';
		$this->enrollAStudent($student_id);
	}

	private function enrollAStudent($student_id){
		$enrollment['user_id'] = $student_id;
		$enrollment['type'] = "StudentEnrollment";
		$enrollment['enrollment_state'] = "active";
		$this->data_field = array(
			"enrollment"=>$enrollment,
		);
		$this->execute('POST');
	}
}