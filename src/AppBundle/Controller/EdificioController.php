<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Edificio;
use Symfony\Component\Validator\Constraints\DateTime;

class EdificioController extends Controller{
	protected $tipo_unidades = array('Departamentos', 'Cocheras', 'Ambos');

	/**
	*@Route("nuevo/edificio/", name="nuevo_edificio")
	*/

	public function nuevoEdificio(Request $request){

		$edificio = new Edificio();
		$form = $this->armarFormularioEdificio($edificio);
		$form->handleRequest($request);
		if ($form->isValid()) {
			$response = $this->altaEdificio($form);
			if ($response != null)
				return $response;
			else{
				$this->addFlash(
					'notice',
					'Ya existe un edificio con esa dirección!'
					);
			}
		}
		return $this->render('edificio/edificio.html.twig', 
							array ('form' => $form->createView(), 
								'operacion' => 'Crear Edificio')
							);
	}

	private function armarFormularioEdificio($edificio){
		return $this->createFormBuilder($edificio)
						//->setAction($this->generateUrl('target_route'))
						->setMethod('POST')
						->add('nombre', 'text')
						->add('direccion', 'text')
						->add('tipo_unidades', 'choice', array('choices' => $this->tipo_unidades))
						->add('observaciones', 'text')
						->add('guardar', 'submit', array('label' => 'GUARDAR EDIFICIO'))
						->getForm();
	}

	private function altaEdificio($form){
		$direccion = $form['direccion']->getData();
		$rep = $this->getDoctrine()->getRepository('AppBundle:Edificio');
		
		$edificio = $rep->findByDireccion($direccion);
		if (!$edificio){
			$edificio = new Edificio();
			$this->guardarDatos($form, $edificio);
			$response = $this->redirectToRoute('operacion_completada');
		}
		else{
			$response = null;
		}

		return $response;
	}

	private function guardarDatos($form, $edificio){
		$edificio->setNombre($form['nombre']->getData())
					->setDireccion($form['direccion']->getData())
					->setTipoUnidades($form['tipo_unidades']->getData())
					->setObservaciones($form['observaciones']->getData());
		$em = $this->getDoctrine()->getManager();
		$em->persist($edificio);
		$em->flush();
	}

}