<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array('Mensaje' => ''));
    }

    /**
	* @Route("op_completada", name="operacion_completada")
	*/
	public function opCompletada(){
		return $this->render('default/index.html.twig', array('Mensaje' => 'OPERACION COMPLETADA'));
		
	}

}
