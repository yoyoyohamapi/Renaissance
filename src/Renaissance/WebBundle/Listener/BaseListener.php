<?php
namespace Renaissance\WebBundle\Listener;

class BaseListener{
	protected $container;

	public function __construct($container){
		$this->container = $container;
	}
}