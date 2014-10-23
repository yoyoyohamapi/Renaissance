<?php
namespace Renaissance\CommonBundle\REST;
use Renaissance\CommonBundle\REST\REST_Base;

class ModulesREST extends BaseREST{
	public function getModulesByCourseId($id){
		$this->api = "courses/".$id."/modules?include[]=items";
		$chapters = $this->execute();
		return $chapters;
	}
}