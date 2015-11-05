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
	/**
	* @Route("guardarcli", name="guardarcliente")
	*/
	public function guardarPropietarioAction(){
		$dni = 11234568;
		$rep = $this->getDoctrine()->getRepository('AppBundle:Propietario');
		$propietario = $rep->findByNrodoc($dni);
		if (!$propietario){
			$propietario = new Propietario();
			$propietario->setApellido("perez");
			$propietario->setNombres("juan martin");
			$propietario->setNrodoc($dni);

			$propietario->setBanco("Galicia");
			$em = $this->getDoctrine()->getManager();
			$em->persist($propietario);
			$em->flush();
			return new Response("Propietario Creado: ". $propietario->getId());
		}
		else{
			return new Response("Ya existe un propietario con ese dni ");	
		}


	}

	/**
	* @Route("buscarprop/{id}")
	*/
	public function buscarPropietario($id){
		$rep = $this->getDoctrine()->getRepository('AppBundle:Propietario');
		$propietario = $rep->find($id);
		return new Response($propietario->getBanco());
	}

	
}