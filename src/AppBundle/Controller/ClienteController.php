<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Operacion;
use AppBundle\Entity\Propietario;

class ClienteController extends Controller
{
	public function guardarPropietarioAction($request){
		/*
		// retrieve GET and POST variables respectively
		$request->query->get('foo');
		$request->request->get('bar', 'default value if bar does not exist');
		*/
		
		/*
		$rep = $this->getDoctrine()->getRepository('AppBundle:Propietario');
		$propietario = $rep->findByNrodoc($dni);
		if (!$propietario){
			
			$propietario = new Propietario();
			$propietario->setApellido($request->query->get('apellido'));
			$propietario->setNombres($request->query->get('nombres'));
			$propietario->setNrodoc($request->query->get('nrodoc'));

			
			$em = $this->getDoctrine()->getManager();
			$em->persist($propietario);
			$em->flush();
			/
			return new Response("Propietario Creado: ". $propietario->getId());
		}
		else{
			return new Response("Ya existe un propietario con el dni " . $dni);	
		}

		return $this->redirectToRoute('operacion_completa', 307);	
		*/

	}

	/**
	* @Route("buscarprop/{id}")
	*/
	public function buscarPropietario($id){
		$rep = $this->getDoctrine()->getRepository('AppBundle:Propietario');
		$propietario = $rep->find($id);
		return new Response($propietario->getBanco());
	}

	/**
	* @Route("op_completada", name="operacion_completada")
	*/
	public function opCompletada(){

		return new Response("operacion completada");
	}

	
}