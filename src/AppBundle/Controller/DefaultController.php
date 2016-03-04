<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        if ($this->checkLogin())
            return $this->render('default/index.html.twig', array('Mensaje' => ''));
    }

    /**
	* @Route("op_completada", name="operacion_completada")
	*/
	public function opCompletada(){
		return $this->render('default/index.html.twig', 
                array('Mensaje' => 'OPERACION COMPLETADA'
                        ));
		
	}

    public function checkLogin(){
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        else
            return true;
    }

    /**
    * @Route("/logout", name="logout")
    */
    public function logout(){
        return new Response('logout');
    }

}
