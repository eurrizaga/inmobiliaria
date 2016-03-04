<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Cliente;
use AppBundle\Entity\Propietario;
use AppBundle\Entity\Unidad;
use AppBundle\Entity\Cochera;
use AppBundle\Entity\Alquiler;
use AppBundle\Entity\Reserva;
use Symfony\Component\Validator\Constraints\DateTime;

class ClienteController extends Controller
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
			$response = $this->altaCliente($form, 'propietario');
			if ($response != null)
				return $response;
			else{
				$this->addFlash(
					'notice',
					'Ya existe un propietario con ese documento!'
					);
			}
		}
		return $this->render('propietario/propietario.html.twig', 
							array ('form' => $form->createView(), 
								'operacion' => 'Crear Propietario')
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
			$this->guardarDatos($form, $propietario);
			return $this->redirectToRoute('operacion_completada');
		}
		return $this->render('propietario/propietario.html.twig', 
							array ('form' => $form->createView(), 
								'operacion' => 'Modificar Propietario')
							);

	}

	/**
	*@Route("buscar/propietario", name="buscar_propietario")
	*/
	public function buscaPropietario(Request $request){
		$form = $this->armarFormularioBusquedaPropietario();
		$form->handleRequest($request);
		$propietarios = null;

		if ($form->isValid()){
			$repository = $this -> getDoctrine()
								-> getRepository('AppBundle:Propietario');
			
			$query = $repository->createQueryBuilder('p');
			$cond = "1 = 1";
			$apellido = $form['apellido']->getData();
			if ($apellido != '')
				$cond.= " AND p.apellido LIKE '%$apellido%' ";
			$nombres = $form['nombres']->getData();
			if ($nombres != '')
				$cond.= " AND p.nombres LIKE '%$nombres%' ";
			$nrodoc = $form['nrodoc']->getData();
			if ($nrodoc != '')
				$cond.= " AND p.nrodoc LIKE '%$nrodoc%' ";
			$direccion = $form['direccion']->getData();
			if ($direccion != '')
				$cond.= " AND p.direccion LIKE '%$direccion%' ";
			$num_carpeta = $form['num_carpeta']->getData();
			if ($num_carpeta != '')
				$cond.= " AND p.num_carpeta LIKE '%$num_carpeta%' ";

			$query = $repository->createQueryBuilder('p')
			->where($cond)
			->getQuery();
			
			$propietarios = $query->getResult();

		}

		return $this->render('busca.html.twig', 
							array ('form' => $form->createView(), 
								'propietarios' => $propietarios, 
								'operacion' => "Buscar Propietarios")
							);
	}

	/**
	*@Route("buscar/propietario/{apellido}/{nombres}/{nrodoc}/{num_carpeta}", name="buscar_propietario_unidad")
	*/
	public function buscaPropietarioUnidad(Request $request, $apellido, $nombres, $nrodoc, $num_carpeta){
		$repository = $this -> getDoctrine()
								-> getRepository('AppBundle:Propietario');
		$query = $repository->createQueryBuilder('p');
		$cond = "1 = 1";
		
		if ($apellido != '0')
			$cond.= " AND p.apellido LIKE '%$apellido%' ";
		if ($nombres != '0')
			$cond.= " AND p.nombres LIKE '%$nombres%' ";
		if ($nrodoc != '0')
			$cond.= " AND p.nrodoc LIKE '%$nrodoc%' ";
		if ($num_carpeta != '0')
			$cond.= " AND p.num_carpeta LIKE '%$num_carpeta%' ";

		$query = $repository->createQueryBuilder('p')
		->where($cond)
		->getQuery();
		
		$propietarios = $query->getResult();

		//return new response('wei') ;
		return $this->render('propietario/listaprop.html.twig', 
							array ('propietarios' => $propietarios, 'cochera' => true)
							);

	}

	/**
	*@Route("buscar/cliente/{apellido}/{nombres}/{nrodoc}", name="buscar_cliente")
	*/
	public function buscaCliente(Request $request, $apellido, $nombres, $nrodoc){
		$repository = $this -> getDoctrine()
								-> getRepository('AppBundle:Cliente');
		$query = $repository->createQueryBuilder('c');
		$cond = "1 = 1";
		
		if ($apellido != '0')
			$cond.= " AND c.apellido LIKE '%$apellido%' ";
		if ($nombres != '0')
			$cond.= " AND c.nombres LIKE '%$nombres%' ";
		if ($nrodoc != '0')
			$cond.= " AND c.nrodoc LIKE '%$nrodoc%' ";
		
		$query = $repository->createQueryBuilder('c')
		->where($cond)
		->getQuery();
		
		$clientes = $query->getResult();

		//return new response('wei') ;
		return $this->render('cliente/listaclientes.html.twig', 
							array ('clientes' => $clientes, 'cochera' => true)
							);

	}

	/**
	*@Route("baja/propietario/{id}", name="baja_propietario")
	*/

	public function bajaPropietario(Request $request, $id){
		$propietario = new Propietario();
		$em = $this->getDoctrine()->getManager();
		$propietario = $em->getRepository('AppBundle:Propietario')->find($id);

		$form = $this->createFormBuilder($propietario)
				//->setAction($this->generateUrl('target_route'))
				->add('volver', 'button', array('label' => 'VOLVER ATRÁS'))
				->add('guardar', 'submit', array('label' => 'BORRAR PROPIETARIO'))
				->getForm();

		$form->handleRequest($request);
		
		if ($form->isValid()) {
			$em->remove($propietario);
			$em->flush();
			return $this->redirectToRoute('operacion_completada');
			
		}
		

		return $this->render('propietario/propietario.html.twig', 
							array ('form' => $form->createView(), 
								'operacion' => '¿Está seguro de que desea borrar el Propietario?',
								)
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
						->add('observaciones', 'textarea', array('required' => false))
						->add('cuit', 'text')
						->add('iva', 'choice', array('choices' => $this->iva))
						->add('banco', 'text')
						->add('cbu', 'text')
						->add('sucursal', 'text')
						->add('num_carpeta', 'text')
						->add('guardar', 'submit', array('label' => 'GUARDAR PROPIETARIO'))
						->getForm();
	}

	private function armarFormularioBusquedaPropietario(){
		return $this->createFormBuilder()
						//->setAction($this->generateUrl('target_route'))
						->setMethod('POST')
						->add('apellido', 'text', array('required' => false))
						->add('nombres', 'text', array('required' => false))
						->add('nrodoc', 'text', array('label' => 'Nro de documento', 'required' => false))
						->add('direccion', 'text', array('required' => false))
						->add('localidad', 'text', array('required' => false))
						->add('num_carpeta', 'text', array('required' => false))
						->add('buscar', 'submit', array('label' => 'BUSCAR PROPIETARIO'))
						->getForm();
	}
	private function guardarDatos($form, $cliente, $tipo){
		if ($tipo === 'cliente'){
			$cliente->setApellido($form['apellido']->getData())
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
					->setIva($form['iva']->getData());
		}
		else
		{
			$cliente->setApellido($form['apellido']->getData())
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
		}
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($propietario);
		$em->flush();
	}
	private function altaCliente($form, $tipo = 'cliente'){
		$nrodoc = $form['nrodoc']->getData();
		$rep = $this->getDoctrine()->getRepository('AppBundle:Propietario');
		
		$cliente = $rep->findByNrodoc($nrodoc);
		if (!$cliente){
			if ($tipo === 'cliente')
				$cliente = new Cliente();
			else
				$cliente = new Propietario();

			$this->guardarDatos($form, $cliente, $tipo);
			$response = $this->redirectToRoute('operacion_completada');
		}
		else{
			$response = null;
		}

		return $response;
	}

	public function buscarCliente($id){
		$rep = $this->getDoctrine()->getRepository('AppBundle:Cliente');
		$cliente = $rep->find($id);
		return $cliente;
	}
	public function buscarClienteDNI($nrodoc){
		$rep = $this->getDoctrine()->getRepository('AppBundle:Cliente');
		$cliente = $rep->findByNrodoc($nrodoc);
		return $cliente;
	}
}