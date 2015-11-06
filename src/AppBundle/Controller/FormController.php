<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Propietario;
use Symfony\Component\Validator\Constraints\DateTime;

class FormController extends Controller
{
	//vectores
	protected $provincias = array('Buenos Aires',
								'Mendoza',
								'Santa Fé');
	protected $iva = array('Responsable Inscripto', 'Exento','Monotributo', 'Consumidor Final');
	
	/**
	*@Route("nuevo/propietario/", name="nuevo_propietario")
	*/
	public function altaPropietarioAction(Request $request){
		$propietario = new Propietario();
		$form = $this->armarFormularioPropietario($propietario);
		$form->handleRequest($request);
		if ($form->isValid()) {
			$rep = $this->getDoctrine()->getRepository('AppBundle:Propietario');
			$nrodoc = $form['nrodoc']->getData();
			$propietario = $rep->findByNrodoc($nrodoc);
			if (!$propietario){
				$propietario = new Propietario();
				$this->guardarPropietario($form, $propietario);
				return $this->redirectToRoute('operacion_completada');
			}
			else{
				$this->addFlash(
					'notice',
					'Ya existe un propietario con ese documento!'
					);
				//return new Response("Ya existe un propietario con el documento " . $nrodoc);	
			}
		}
		return $this->render('propietario/propietario.html.twig', 
							array ('form' => $form->createView())
							);
	}

	/**
	*@Route("modificar/propietario/{id}", name="modificar_propietario")
	*/
	public function modificaPropietario(Request $request, $id){
		$propietario = new Propietario();
		$repository = $this->getDoctrine()
							->getRepository('AppBundle:Propietario');
		$propietario = $repository -> find($id);
		$form = $this->armarFormularioPropietario($propietario);

		$form->handleRequest($request);
		if ($form->isValid()) {
			//$propietario = $rep->find($id);
			$this->guardarPropietario($form, $propietario);
			return $this->redirectToRoute('operacion_completada');
		}
		return $this->render('propietario/propietario.html.twig', 
							array ('form' => $form->createView())
							);

	}

	/**
	*@Route("buscar/propietario", name="buscar_propietario")
	*/
	public function buscaPropietario(Request $request){
		$repository = $this -> getDoctrine()
							-> getRepository('AppBundle:Propietario');
		
		$propietarios = $repository -> findAll();
		
		return $this->render('propietario/busca.html.twig', 
							array ('propietarios' => $propietarios)
							);
	}


	private function armarFormularioPropietario($propietario){
		return $this->createFormBuilder($propietario)
						//->setAction($this->generateUrl('target_route'))
						->setMethod('POST')
						->add('apellido', 'text')
						->add('nombres', 'text')
						->add('tipodoc', 'choice', array('choices'  => array('DNI' => 'DNI', 'LE' => 'LE')))
						->add('nrodoc', 'text', array('label' => 'Nro de documento'))
						->add('direccion', 'text')
						->add('localidad', 'text')
						->add('codigopostal', 'text')
						->add('provincia', 'choice', array('choices' => $this->provincias))
						->add('pais', 'text', array('data' => 'Argentina'))
						->add('telefonofijo', 'text')
						->add('telefonomovil', 'text')
						->add('email', 'text')
						->add('observaciones', 'textarea')
						->add('cuit', 'text')
						->add('iva', 'choice', array('choices' => $this->iva))
						->add('banco', 'text')
						->add('cbu', 'text')
						->add('sucursal', 'text')
						->add('num_carpeta', 'text')
						->add('guardar', 'submit', array('label' => 'GUARDAR PROPIETARIO'))
						->getForm();
	}

	private function guardarPropietario($form, $propietario){
		$propietario->setApellido($form['apellido']->getData())
					->setNombres($form['nombres']->getData())
					->setTipodoc($form['tipodoc']->getData())
					->setNrodoc($form['nrodoc']->getData())
					->setDireccion($form['direccion']->getData())
					->setLocalidad($form['localidad']->getData())
					->setCodigopostal($form['codigopostal']->getData())
					->setProvincia($form['provincia']->getData())
					->setPais($form['pais']->getData())
					->setTelefonofijo($form['telefonofijo']->getData())
					->setTelefonomovil($form['telefonomovil']->getData())
					->setEmail($form['email']->getData())
					->setObservaciones($form['observaciones']->getData())
					->setIva($form['iva']->getData())
					->setCuit($form['cuit']->getData())
					->setCbu($form['cbu']->getData())
					->setBanco($form['banco']->getData())
					->setSucursal($form['sucursal']->getData())
					->setNumCarpeta($form['num_carpeta']->getData());

		$em = $this->getDoctrine()->getManager();
		$em->persist($propietario);
		$em->flush();
	}
}