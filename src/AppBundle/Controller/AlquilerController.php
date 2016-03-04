<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;
use AppBundle\Entity\Cliente;
use AppBundle\Entity\Propietario;
use AppBundle\Entity\Unidad;
use AppBundle\Entity\Cochera;
use AppBundle\Entity\Alquiler;
use AppBundle\Entity\Reserva;

class AlquilerController extends Controller{
	protected $provincias = array('Buenos Aires',
								'Mendoza',
								'Santa Fé');

	/**
	*@Route("cochera/alquiler/{id}/{desde}/{hasta}", name="nuevo_alquiler_cochera")
	*/
	public function altaAlquilerCochera(Request $request, $id, $desde, $hasta){
		//ooohhh boy
		$cliente = new Cliente();
		$alquiler = new Alquiler();
		$form_busca = $this->generarFormularioBuscaCliente();
		$form = $this->generarFormularioAlquiler();
		$form['id_unidad']->setData($id);
		$form['fecha_desde']->setData($desde);
		$form['fecha_hasta']->setData($hasta);

		$form->handleRequest($request);
		if ($form->isValid()) {
			$response = $this->altaAlquiler($form);
			if ($response != null)
				return $response;
			else{
				$this->addFlash(
					'notice',
					'Error!'
					);
			}
		}
		else{
			$repository = $this->getDoctrine()->getRepository('AppBundle:Unidad');
			$unidad = $repository->find($id);
		}
		return $this->render('alquiler/alquiler.html.twig', 
							array ('form' => $form->createView(),
									'form_busca' => $form_busca->createView(),
									'desde' => $desde,
									'hasta' => $hasta,
									'operacion' => 'Nuevo Alquiler')
							);

	}
	/**
	*@Route("cochera/reserva/{id}/{desde}/{hasta}", name="nueva_reserva_cochera")
	*/
	public function buscarAlquileres(Request $request){
		//ooohhh boy
		
		return new Response('wei');
	}


	/**
	*@Route("cochera/reserva/{id}/{desde}/{hasta}", name="nueva_reserva_cochera")
	*/
	public function altaReservaCochera(Request $request, $id, $desde, $hasta){
		//ooohhh boy
		return new Response('wei');
	}

	private function generarFormularioAlquiler(){
		return $this->createFormBuilder()
				//->setAction($this->generateUrl('target_route'))
				->setMethod('POST')
				->add('id_cliente', 'hidden')
				->add('id_unidad', 'hidden')
				->add('fecha_desde', 'hidden')
				->add('fecha_hasta', 'hidden')
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
				->add('observaciones_cliente', 'textarea', array('required' => false))
				->add('monto_base', 'text')
				->add('monto_recargo', 'text')
				->add('monto_abonado', 'text')
				->add('promesa_fecha', 'date',  array('widget' => 'single_text'))
				->add('comision', 'text')
				->add('observaciones', 'textarea', array('required' => false))
				->add('guardar', 'submit', array('label' => 'GENERAR ALQUILER'))
				->getForm();
	}

	private function generarFormularioBuscaCliente(){
		return $this->createFormBuilder()
						//->setAction($this->generateUrl('target_route'))
						->setMethod('POST')
						->add('apellido_busca', 'text', array('required' => false))
						->add('nombres_busca', 'text', array('required' => false))
						->add('nrodoc_busca', 'text', array('label' => 'Nro de documento', 'required' => false))
						->add('busca_cliente', 'button', array('label' => 'BUSCAR CLIENTE', 'attr' => array('onclick' => 'buscarClientes()')))
						->add('nuevo_cliente', 'button', array('label' => 'NUEVO CLIENTE', 'attr' => array('onclick' => 'nuevoCliente()')))
						->getForm();
	}

	private function altaAlquiler($form){
		$cc = new ClienteController();
		$cc->setContainer($this->container);
		$cliente = $cc->buscarCliente($form['id_cliente']->getData());
		if (!$cliente){
			$cc->altaCliente($form);
			$cliente = $cc->buscarClienteDNI($form['nrodoc']->getData());
		}
		$uc = new UnidadController();
		$uc->setContainer($this->container);
		$unidad = $uc->buscarUnidad($form['id_unidad']->getData());

		$fecha_desde = date_create($form['fecha_desde']->getData());
		$fecha_hasta = date_create($form['fecha_hasta']->getData());

		$dc = new DisponibilidadController();
		$dc -> setContainer($this->container);
		$disponibilidad = $dc -> buscar($fecha_desde, $fecha_hasta, $unidad);
		
		if ($disponibilidad){
			$dc -> setearDisponibilidad($unidad, $fecha_desde, $fecha_hasta, 'a');
			//Crear Alquiler
			$operacion = new Alquiler();
			$operacion -> setCliente($cliente);
			$operacion -> setUnidad($unidad);
			$operacion -> setFechaDesde($fecha_desde);
			$operacion -> setFechaHasta($fecha_hasta);
			$operacion -> setUsuario($this->getUser());
			$operacion -> setPromesaFecha($form['promesa_fecha']->getData());
			
			$operacion -> setComision($form['comision']->getData());
			$operacion -> setObservaciones($form['observaciones']->getData());
			$operacion -> setMontoTotal($form['monto_base']->getData());
			$operacion -> setMontoAbonado($form['monto_abonado']->getData());
			$operacion -> setMontoRecargo($form['monto_recargo']->getData());
			$operacion -> setPromesaFecha($form['promesa_fecha']->getData());
			
			$now = new \DateTime('now'); //poner la / para que se interprete como datetime de php y no de symfony
			$operacion -> setFechaHora($now);
			//Actualizar Cuenta Corriente del propietario
			//Actualizar Log

			$em = $this->getDoctrine()->getManager();
			$em->persist($cliente);
			$em->persist($unidad);
			$em->persist($this->getUser());
			$em->persist($operacion);
			$em->flush();

			$response = $this->redirectToRoute('operacion_completada');
		}
		else{
			$response = new Response('Unidad ya no disponible en ese periodo');
		}
		return $response;

		/*
		$nrodoc = $form['nrodoc']->getData();
		$rep = $this->getDoctrine()->getRepository('AppBundle:Propietario');
		
		$propietario = $rep->findByNrodoc($nrodoc);
		if (!$propietario){
			$propietario = new Propietario();
			$this->guardarDatos($form, $propietario);
			
		}
		else{
			$response = null;
		}

		return $response;
		*/
	}



}