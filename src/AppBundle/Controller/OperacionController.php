<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Operacion;
use AppBundle\Entity\Propietario;

class OperacionController extends Controller
{
	/**
	* @Route("guardarop", name="guardaroperacion")
	*/
	public function guardarAction(){
		return new Response("WEEEEEEEEEEEE");

	}
}