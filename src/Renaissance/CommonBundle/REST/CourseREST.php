<?php
namespace Renaissance\CommonBundle\REST;
use Renaissance\CommonBundle\REST\REST_Base;

class CourseREST extends BaseREST{

	public function getAllCourses(){
		$this->api="courses";
		return $this->curlHelper->curlGet($this->api);
	}
}