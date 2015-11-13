<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Cochera;
use AppBundle\Entity\Propietario;
use AppBundle\Entity\Autorizacion;
use AppBundle\Entity\Disponibilidad;
use Symfony\Component\Validator\Constraints\DateTime;

class UnidadController extends Controller
{
	protected $categorias = array('1', '2', '3', 'A', 'B', 'C');
	protected $op_habilitadas = array('Alquiler', 'Venta', 'Ambos');
	protected $periodos_sel = array('diario' => 'diario', 'semanal' => 'semanal', 'quincenal' => 'quincenal', 'mensual' => 'mensual');
	/**
	*@Route("nuevo/unidad/cochera", name="nueva_cochera")
	*/
	public function nuevaCochera(Request $request){
		$form = $this->armarFormularioCochera();
		$form_prop = $this->createFormBuilder()
						//->setAction($this->generateUrl('target_route'))
						->setMethod('POST')
						->add('apellido', 'text', array('required' => false))
						->add('nombres', 'text', array('required' => false))
						->add('nrodoc', 'text', array('label' => 'Nro de documento', 'required' => false))
						->add('num_carpeta', 'text', array('required' => false))
						->add('buscar', 'button', array('label' => 'BUSCAR PROPIETARIO', 'attr' =>  array('onclick' => 'buscarPropietarios();')))
						->getForm();

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
		return $this->render('unidad/cochera.html.twig', 
							array ('form' => $form->createView(),
									'form_prop' => $form_prop->createView(), 
								'operacion' => 'Crear Cochera')
							);
	}

	private function altaCochera($form){
		$rep_edificio = $this->getDoctrine()->getRepository('AppBundle:Edificio');
		
		//obtener edificio por id
		$edificio = $rep_edificio->find($form['edificio']->getData());
		
		//buscar cochera considerando edificio y numero
		$rep_cochera = $this->getDoctrine()->getRepository('AppBundle:Cochera');

		$numero = $form['numero']->getData();
		
		$cochera = $rep_cochera->findByNumero($numero);

		if (!$cochera){
			$cochera = new Cochera();
			
			$this->guardarDatos($form, $cochera);
			
			$response = $this->redirectToRoute('operacion_completada');
			
		}
		else{
			$response = null;
		}

		return $response;
	}

	private function guardarDatos($form, $unidad){
		//obtener edificio por id
		$rep_edificio = $this->getDoctrine()->getRepository('AppBundle:Edificio');
		$edificio = $rep_edificio->find($form['edificio']->getData());

		//obtener propietario por id
		$rep_propietario = $this->getDoctrine()->getRepository('AppBundle:Propietario');
		$propietario = $rep_propietario->find($form['propietario']->getData());

		
		$unidad -> setEdificio($edificio)
				-> setPropietario($propietario)
				-> setNumero($form['propietario']->getData())
				-> setNumCarpeta($form['num_carpeta']->getData())
				-> setDetalles($form['detalles']->getData())
				-> setPeriodoSugerido($form['periodo_sugerido']->getData())
				-> setCategoria($form['categoria']->getData())
				-> setAncho($form['ancho']->getData())
				-> setLargo($form['largo']->getData())
				-> setSubsuelo($form['subsuelo']->getData())
				-> setDistanciaAscensor($form['distancia_ascensor']->getData())
				-> setDistanciaEscaleraCaracol($form['distancia_escalera_caracol']->getData())
				-> setDistanciaEscaleraBristol($form['distancia_escalera_bristol']->getData())
				-> setDistanciaEscaleraIzq($form['distancia_escalera_izq']->getData())
				-> setDistanciaEscaleraDer($form['distancia_escalera_der']->getData())
				-> setCodigo($form['codigo']->getData())
				-> setOpHabilitadas($form['op_habilitadas']->getData());
		
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($unidad);
		$em->flush();
	}

	private function armarFormularioCochera($cochera = null){
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
			$lista_edificios += array($e->getId() => ($e->getNombre()."(".$e->getDireccion().")"));
		}


		return $this->createFormBuilder()
						//->setAction($this->generateUrl('target_route'))
						->setMethod('POST')
						->add('edificio', 'choice', array('choices' => $lista_edificios))
						->add('numero', 'text')
						->add('propietario', 'text')
						->add('buscar', 'button', array('attr' => array('onclick' => 'buscarPropietarios();')))
						->add('op_habilitadas', 'choice', array('choices' => $this->op_habilitadas))
						->add('num_carpeta', 'text')
						->add('detalles', 'textarea')
						->add('periodo_sugerido', 'choice', array('choices' => $this->periodos_sel))
						->add('categoria', 'choice', array('choices' => $this->categorias))
						->add('ancho', 'text')
						->add('largo', 'text')
						->add('subsuelo', 'text')
						->add('distancia_ascensor', 'text')
						->add('distancia_escalera_caracol', 'text')
						->add('distancia_escalera_bristol', 'text')
						->add('distancia_escalera_izq', 'text')
						->add('distancia_escalera_der', 'text')
						->add('codigo', 'text')
						->add('guardar', 'submit', array('label' => 'GUARDAR COCHERA'))
						->getForm();
	}

	/**
	*@Route("buscar/unidad/cochera", name="buscar_cochera")
	*/
	public function buscaCochera(Request $request){
		$form = $this->armarFormularioBusquedaCochera();
		$form->handleRequest($request);
		$cocheras = null;

		if ($form->isValid()){
			$repository = $this -> getDoctrine()
								-> getRepository('AppBundle:Cochera');

			$query = $repository->createQueryBuilder('p');
			$cond = "1 = 1";
			$edificio = $form['edificio']->getData();
			if ($edificio != '')
				$cond.= " AND p.edificio LIKE '%$apellido%' ";
			$numero = $form['numero']->getData();
			if ($numero != '')
				$cond.= " AND p.numero LIKE '%$numero%' ";
			$num_carpeta = $form['num_carpeta']->getData();
			if ($num_carpeta != '')
				$cond.= " AND p.num_carpeta LIKE '%$num_carpeta%' ";

			$query = $repository->createQueryBuilder('p')
			->where($cond)
			->getQuery();
			
			$cocheras = $query->getResult();

		}
		return $this->render('busca.html.twig', 
							array ('form' => $form->createView(), 
								'cocheras' => $cocheras, 
								'operacion' => "Buscar Cocheras")
							);
	}

	private function armarFormularioBusquedaCochera(){
		return $this->createFormBuilder()
						//->setAction($this->generateUrl('target_route'))
						->setMethod('POST')
						->add('edificio', 'text', array('required' => false))
						->add('numero', 'text', array('required' => false))
						->add('num_carpeta', 'text', array('required' => false))
						->add('buscar', 'submit', array('label' => 'BUSCAR PROPIETARIO'))
						->getForm();
	}

	/**
	*@Route("modificar/unidad/cochera/{id}", name="modificar_cochera")
	*/
	public function modificarCochera(Request $request, $id){
		$cochera = new Cochera();
		$repository = $this->getDoctrine()
							->getRepository('AppBundle:Cochera');
		$cochera = $repository -> find($id);
		$form = $this->armarFormularioCochera($cochera);
		$form = $this->completarFormularioCochera($form, $id);

		$form->handleRequest($request);
		if ($form->isValid()) {
			$this->guardarDatos($form, $cochera);
			return $this->redirectToRoute('operacion_completada');
		}

		$form_prop = $this->createFormBuilder()
						//->setAction($this->generateUrl('target_route'))
						->setMethod('POST')
						->add('apellido', 'text', array('required' => false))
						->add('nombres', 'text', array('required' => false))
						->add('nrodoc', 'text', array('label' => 'Nro de documento', 'required' => false))
						->add('num_carpeta', 'text', array('required' => false))
						->add('buscar', 'button', array('label' => 'BUSCAR PROPIETARIO', 'attr' =>  array('onclick' => 'buscarPropietarios();')))
						->getForm();

		return $this->render('unidad/cochera.html.twig', 
							array ('form' => $form->createView(),
									'form_prop' => $form_prop->createView(), 
								'operacion' => 'Modificar Cochera')
							);
	}

	private function completarFormularioCochera($form, $id){
		$cochera = new Cochera();
		$repository = $this->getDoctrine()
							->getRepository('AppBundle:Cochera');
		$cochera = $repository -> find($id);
		$form->get('edificio')->setData($cochera->getEdificio()->getNombre());
		$form->get('numero')->setData($cochera->getNumero());
		$form->get('propietario')->setData($cochera->getPropietario()->getId());
		$form->get('op_habilitadas')->setData($cochera->getOpHabilitadas());
		$form->get('num_carpeta')->setData($cochera->getNumCarpeta());
		$form->get('detalles')->setData($cochera->getDetalles());
		$form->get('periodo_sugerido')->setData($cochera->getPeriodoSugerido());
		$form->get('categoria')->setData($cochera->getCategoria());
		$form->get('ancho')->setData($cochera->getAncho());
		$form->get('largo')->setData($cochera->getLargo());
		$form->get('subsuelo')->setData($cochera->getSubsuelo());
		$form->get('distancia_ascensor')->setData($cochera->getDistanciaAscensor());
		$form->get('distancia_escalera_caracol')->setData($cochera->getDistanciaEscaleraCaracol());
		$form->get('distancia_escalera_bristol')->setData($cochera->getDistanciaEscaleraBristol());
		$form->get('distancia_escalera_izq')->setData($cochera->getDistanciaEscaleraIzq());
		$form->get('distancia_escalera_der')->setData($cochera->getDistanciaEscaleraDer());
		$form->get('codigo')->setData($cochera->getCodigo());
		return $form;
	}

	/**
	*@Route("autorizar/unidad/{id}", name="autorizar_cochera")
	*/
	public function autorizarUnidad(Request $request, $id){
		$form = $this->crearFormularioAutorizacion();
		
		$form->handleRequest($request);
		
		if ($form->isValid()) {
			$response = $this->altaAutorizacion($form, $id);
			if ($response != null)
				return $response;
			else{
				$this->addFlash(
					'notice',
					'Ya existe una autorizacion en ese rango de fechas!'
					);
			}
		}
		
		$repository = $this->getDoctrine()
							->getRepository('AppBundle:Autorizacion');
		$repository2 = $this->getDoctrine()
							->getRepository('AppBundle:Unidad');
		
		$lista_autorizaciones = $repository -> findByUnidad($repository2->find($id));
		$forms_mod = array();
		foreach ($lista_autorizaciones as $a) {
	        $forms_mod[] = $this->crearFormularioAutorizacion($a)->createView();
	    }
		
		return $this->render('unidad/autorizacion.html.twig', 
							array ('form' => $form->createView(),
								'operacion' => 'Autorizar Cochera',
								'lista_autorizaciones' => $lista_autorizaciones,
								'lista_forms' => $forms_mod)
							);
	}

	
	private function altaAutorizacion($form, $id){
		$repository = $this->getDoctrine()
							->getRepository('AppBundle:Unidad');
		$unidad = $repository -> find($id);
		$fecha_desde = $form['fecha_desde']->getData();
		$fecha_hasta = $form['fecha_hasta']->getData();
		$aut_encontradas = $this->comprobarFechasAut($fecha_desde, $fecha_hasta, $mod = 0);
		if (!$aut_encontradas){
			$autorizacion = new Autorizacion();
			$autorizacion->setFechaAutorizacion($form['fecha_actual']->getData());
			$autorizacion->setFechaDesde($fecha_desde);
			$autorizacion->setFechaHasta($fecha_hasta);			
			$autorizacion->setUnidad($unidad);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($autorizacion);
			$em->persist($unidad);
			$em->flush();
			
			$response = $this->redirectToRoute('operacion_completada');	
		}
		else
			$response = null;
		return $response;

	}

	private function crearFormularioAutorizacion($autorizacion = null){
		if ($autorizacion != null){
			return $this->createFormBuilder($autorizacion)
						->setAction($this->generateUrl('autorizar_modificar'))
						->setMethod('POST')
						->add('id', 'hidden')
						->add('fecha_autorizacion', 'date', array('required' => false, 'widget' => 'single_text'))
						->add('fecha_desde', 'date', array('required' => false, 'widget' => 'single_text'))
						->add('fecha_hasta', 'date', array('label' => 'Fecha Hasta', 'required' => false, 'widget' => 'single_text'))
						->add('modificar', 'submit', array('label' => 'MODIFICAR'))
						->add('borrar', 'submit', array('label' => 'BORRAR'))
						->getForm();	
		}
		else
			return $this->createFormBuilder()
							//->setAction($this->generateUrl('target_route'))
							->setMethod('POST')
							->add('id', 'hidden')
							->add('fecha_autorizacion', 'date', array('required' => false, 'widget' => 'single_text'))
							->add('fecha_desde', 'date', array('required' => false, 'widget' => 'single_text'))
							->add('fecha_hasta', 'date', array('label' => 'Fecha Hasta', 'required' => false, 'widget' => 'single_text'))
							->add('agregar', 'submit', array('label' => 'AGREGAR AUTORIZACION'))
							->getForm();
	}

	/**
	*@Route("autorizar/modificar/", name="autorizar_modificar")
	*/
	public function modificarAutorizacion(Request $request){
		$autorizacion = new Autorizacion();
		$form = $this->crearFormularioAutorizacion();
		$form->handleRequest($request);
		$id = $form['id']->getData();
		$repository = $this->getDoctrine()
						->getRepository('AppBundle:Autorizacion');
		$autorizacion = $repository -> find($id);
		$em = $this->getDoctrine()->getManager();
		if($form->get('modificar')->isClicked()){
			$fecha_desde = $form['fecha_desde']->getData();
			$fecha_hasta = $form['fecha_hasta']->getData();
			$aut_encontradas = $this->comprobarFechasAut($fecha_desde, $fecha_hasta, $id);

			if (!$aut_encontradas){
				$autorizacion ->setFechaDesde($fecha_desde);
				$autorizacion ->setFechaHasta($fecha_hasta);
				$em->persist($autorizacion);
				$em->flush();
				$response = $this->redirectToRoute('operacion_completada');	
			}
			else{
				$this->addFlash(
					'notice',
					'Ya existe una autorizacion en ese rango de fechas!'
					);
				$response = $this->redirectToRoute('autorizar_cochera');	
			}
		}
		else{
			$em->remove($product);
			$em->flush();
		}
		return $response;
	}
	private function comprobarFechasAut($fecha_desde, $fecha_hasta, $id){
		$em = $this->getDoctrine()->getManager();
		if ($id != 0){
			$query = $em->createQuery(
				'SELECT a
				FROM AppBundle:Autorizacion a
				WHERE ((a.fecha_desde >= :fecha_desde AND a.fecha_hasta <= :fecha_desde)
					OR (a.fecha_desde >= :fecha_hasta AND a.fecha_hasta <= :fecha_hasta))
					AND (a.id != :id)
				ORDER BY a.id ASC')
				->setParameter('fecha_desde', $fecha_desde)
				->setParameter('fecha_hasta', $fecha_hasta)
				->setParameter('id', $id);
		}
		else{
			$query = $em->createQuery(
				'SELECT a
				FROM AppBundle:Autorizacion a
				WHERE (a.fecha_desde >= :fecha_desde AND a.fecha_hasta <= :fecha_desde)
					OR (a.fecha_desde >= :fecha_hasta AND a.fecha_hasta <= :fecha_hasta)
				ORDER BY a.id ASC')
				->setParameter('fecha_desde', $fecha_desde)
				->setParameter('fecha_hasta', $fecha_hasta);
		}
		
		return $query->getResult();
	}
}