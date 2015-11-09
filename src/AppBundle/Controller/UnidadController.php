<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Cochera;
use AppBundle\Entity\Propietario;
use Symfony\Component\Validator\Constraints\DateTime;

class UnidadController extends Controller
{
	protected $categorias = array('1', '2', '3', 'A', 'B', 'C');
	/**
	*@Route("nuevo/unidad/cochera", name="nueva_cochera")
	*/
	public function nuevaCochera(Request $request){
		$unidad = new Cochera();
		$form = $this->armarFormularioCochera($unidad);
		$form->handleRequest($request);
		if ($form->isValid()) {
			$response = $this->altaCochera($form);
			if ($response != null)
				return $response;
			else{
				$this->addFlash(
					'notice',
					'Ya existe una cochera con ese número!'
					);
			}
		}
		return $this->render('propietario/propietario.html.twig', 
							array ('form' => $form->createView(), 
								'operacion' => 'Crear Cochera')
							);
	}

	private function altaCochera($form){
		$nrodoc = $form['nrodoc']->getData();
		$rep = $this->getDoctrine()->getRepository('AppBundle:Propietario');
		
		$propietario = $rep->findByNrodoc($nrodoc);
		if (!$propietario){
			$propietario = new Propietario();
			$this->guardarPropietario($form, $propietario);
			$response = $this->redirectToRoute('operacion_completada');
		}
		else{
			$response = null;
		}

		return $response;
	}

	private function armarFormularioCochera($cochera){
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
				'SELECT p
				FROM AppBundle:Edificio p
				WHERE p.tipo_unidades != :tipo
				ORDER BY p.id ASC'
			)->setParameter('tipo', '0');
		$edificios = $query->getResult();
		$lista_edificios = array();
		foreach ($edificios as $e){
			$lista_edificios[] = ()

		}

		return $this->createFormBuilder($cochera)
						//->setAction($this->generateUrl('target_route'))
						->setMethod('POST')
						->add('edificio', 'choice')
						->add('numero', 'text')
						->add('propietario', 'text')
						->add('buscar', 'button')
						->add('op_habilitadas', 'text')
						->add('codigo', 'text')
						->add('num_carpeta', 'text')
						->add('detalles', 'text')
						->add('periodo_sugerido', 'text')
						->add('categoria', 'choice', array('choices' => $this->categorias))
						->add('ancho', 'text')
						->add('largo', 'text')
						->add('subsuelo', 'text')
						->add('distancia_ascensor', 'text')
						->add('distancia_escalera_caracol', 'text')
						->add('distancia_escalera_bristol', 'text')
						->add('distancia_escalera_izq', 'text')
						->add('distancia_escalera_der', 'text')

						->add('guardar', 'submit', array('label' => 'GUARDAR COCHERA'))
						->getForm();
	}
}