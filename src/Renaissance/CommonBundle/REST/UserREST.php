<?php
namespace Renaissance\CommonBundle\REST;
class UserREST extends BaseREST{
	public function getUserProfile($user_id){
		$this->api = "users/".$user_id."/profile";
		$profile = $this->execute();
		return $profile;
	}
	public function getCourseStudents($course_id){
		$this->api = "courses/".$course_id."/users?enrollment_type=student";
		$students = $this->execute();
		return $students;
	}
	public function getCourseTeachers($course_id){
		$this->api = "courses/".$course_id."/users?enrollment_type=teacher";
		$teachers = $this->execute();
		return $teachers;
	}
}