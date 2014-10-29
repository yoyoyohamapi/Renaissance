<?php
namespace Renaissance\CommonBundle\REST;
use Renaissance\CommonBundle\REST\REST_Base;

//作业组
class AssignmentGroupsREST extends BaseREST{
	//获取课程作业组
	public function getAssignmentGroups($course_id){
		$this->api = 'courses/'.$course_id.'/assignment_groups';
		return $this->execute();
	}
	//获取课程某一作业组
	public function getAssignmentGroupById($course_id, $assignment_group_id){
		$this->api = 'courses/'.$course_id.'/assignment_groups/'.$assignment_group_id;
		return $this->execute();
	}
	//创建课程作业组
	public function createAssignmentGroup($course_id, $name, $weight){
		$this->api = 'courses/'.$course_id.'/assignment_groups';
		$this->data_field = array(
			"name"=>$name,
			'group_weight'=>$weight,
		);
		$this->execute('POST');
	}
}