<?php

namespace Renaissance\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController extends Controller
{
	    protected function createJsonResponse($data)
	    {
	        return new JsonResponse($data);
	    }
}
