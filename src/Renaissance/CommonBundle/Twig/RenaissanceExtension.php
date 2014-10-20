<?php
namespace Renaissance\CommonBundle\Twig;

class RenaissanceExtension extends \Twig_Extension
{

	protected $container;

	public function __construct ($container)
	{
	    $this->container = $container;
	}

	// Register Filters
	public function getFilters(){
		return array(

		);
	}

	// Register Functions
	public function getFunctions(){
		return array(
			'getUser' => new \Twig_Function_Method($this,'getCurrentUser'),
		);
	} 


	//Return the Extension Name 
	public function getName(){
		return 'Twig_Extension';
	}


	public function getCurrentUser(){
		if (!$this->container->has('security.context')) {
		    throw new \LogicException('The SecurityBundle is not registered in your application.');
		}

		if (null === $token = $this->container->get('security.context')->getToken()) {
		    return;
		}

		if (!is_object($user = $token->getUser())) {
		    return;
		}

		return $user;
	}
}