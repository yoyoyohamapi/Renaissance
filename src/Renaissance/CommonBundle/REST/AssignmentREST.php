<?php
namespace Renaissance\CommonBundle\REST;
use Renaissance\CommonBundle\REST\REST_Base;

class AssignmentREST extends BaseREST{
	public function getAssignments($course_id){
		$this->api = 'courses/'.$course_id.'/assignments';
		return $this->execute();
	}
}