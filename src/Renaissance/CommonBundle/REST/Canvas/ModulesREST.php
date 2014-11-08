<?php
namespace Renaissance\CommonBundle\REST\Canvas;

class ModulesREST extends CanvasBaseREST{
	public function getModulesByCourseId($id){
		$this->api = "courses/".$id."/modules?include[]=items";
		$chapters = $this->execute();
		return $chapters;
	}
}