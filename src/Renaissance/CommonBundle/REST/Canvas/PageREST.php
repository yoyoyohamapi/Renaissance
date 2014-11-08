<?php
namespace Renaissance\CommonBundle\REST\Canvas;

class PageREST extends CanvasBaseREST{
	public function getPageByCourseId($id){
		$this->api = "courses/".$id."/front_page";
        		$page = $this->execute();
        		return $page;
	}
}