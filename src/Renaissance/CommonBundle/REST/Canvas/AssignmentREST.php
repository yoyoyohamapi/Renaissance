<?php
namespace Renaissance\CommonBundle\REST\Canvas;

class AssignmentREST extends CanvasBaseREST{
	public function getAssignments($course_id){
		$this->api = 'courses/'.$course_id.'/assignments';
		return $this->execute();
	}
}