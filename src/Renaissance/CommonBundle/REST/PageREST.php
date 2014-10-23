<?php
namespace Renaissance\CommonBundle\REST;
use Renaissance\CommonBundle\REST\REST_Base;

class PageREST extends BaseREST{
	public function getPageByCourseId($id){
		$this->api = "courses/".$id."/front_page";
        		$page = $this->execute();
        		return $page;
	}
}