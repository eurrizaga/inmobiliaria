<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Propietario;

class FormController extends Controller
{
	/**
	*@Route("nuevo/propietario/", name="nuevo_propietario")
	*/
	public function formAltaPropietarioAction(Request $request){
		$propietario = new Propietario();

		$form = $this->createFormBuilder($propietario)
						->add('Apellido', 'text')
						->add('Nombres', 'text')
						->add('Nrodoc', 'text', array('label' => 'Nro de documento'))
						->add('GUARDAR', 'submit', array('label' => 'GUARDAR PROPIETARIO'))
						->getForm();
		
		$form->handleRequest($request);
		if ($form->isValid()) {
			return $this->redirectToRoute('guardar_propietario', ['request' => $request], 307);
		}

		return $this->render('propietario/propietario.html.twig', array ('form' => $form->createView()));

	}
}