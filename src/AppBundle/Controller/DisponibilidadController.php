<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Disponibilidad;

use Symfony\Component\Validator\Constraints\DateTime;

class DisponibilidadController extends Controller{

	/**
	* @Route("/buscar/disponibilidades/cochera", name="disponibilidades_cochera")
	*/
	public function listarDisponibilidadesCochera(Request $request){
		$form = $this->crearFormDisponibilidades();
		$form->handleRequest($request);
		$unidades_libres = null;
		$fecha_desde = new DateTime();
		$fecha_hasta = new DateTime();
		if ($form->isValid()){
			$fecha_desde = $form['fecha_desde']->getData();
			$fecha_hasta = $form['fecha_hasta']->getData();
			$disponibilidades = $this->buscar($fecha_desde, $fecha_hasta);
			$unidades_libres = $this->filtrarDisponibles($disponibilidades, $fecha_desde, $fecha_hasta);
		}

		return $this->render('unidad/disponibilidades.html.twig', 
							array ('form' => $form->createView(),
								'unidades' => $unidades_libres,
								'operacion' => 'Buscar Disponibilidades',
								'desde' => $fecha_desde->format("Y-m-d"),
								'hasta' => $fecha_hasta->format("Y-m-d"))
							);
		//return new Response('wei');
	}

	private function filtrarDisponibles($disponibilidades, $fecha_desde, $fecha_hasta){
		$cant_meses = $disponibilidades['cant_meses'];
		$unidades = $disponibilidades['resultado'];
		$cadena = array();
		$cont = array();
		$listado_agrupado = array();
		$unidades_validas = array();
		foreach ($unidades as $u){
			$id_unidad = $u->getUnidad()->getId();
			//agrupo por unidad
			if (!isset($listado_agrupado[$id_unidad])){
				$listado_agrupado[$id_unidad] = array('resultados' => $u->getUnidad(), 
														'cadena' => '', 
														'cont_meses' => 0);
			}
			//genero cadena completa
			$listado_agrupado[$id_unidad]['cadena'].= $u->getCadena();
			//cuento cantidad de meses
			$listado_agrupado[$id_unidad]['cont_meses']++;
	    }


	    foreach ($listado_agrupado as $lu){
	    	if ($lu['cont_meses'] >= $cant_meses){
	    		$inicio_periodo = $fecha_desde->format("d") - 1;
	    		$limite = strlen($lu['cadena']) - $inicio_periodo - (31 - $fecha_hasta->format("d")); //cant de dias que se busca alquilar
	    		$cadena_reducida = substr($lu['cadena'], $inicio_periodo, $limite);

	    		if ($this->cadenaValida($cadena_reducida)){
	    			$unidades_validas[] = $lu;
	    		}
	    	}
	    }

	    return $unidades_validas;

	}
	private function cadenaValida($cadena){
		return ((strpos($cadena,'0') === false) && (strpos($cadena,'a') === false) && (strpos($cadena,'r') === false));
	}
	public function buscar($fecha_desde, $fecha_hasta, $unidad = null){
		$mes1 = $fecha_desde->format("m");
		$anio1 = $fecha_desde->format("Y");

		$mes2 = $fecha_hasta->format("m");
		$anio2 = $fecha_hasta->format("Y");

		if ($unidad)
			$cond = "(d.unidad = :unidad) AND ";
		else
			$cond = "";

		if ($anio1 == $anio2){
	        $cond .= "(( d.mes >= ".intval($mes1).") AND (d.mes <= ".intval($mes2).")) AND (d.anio = ".$anio1.")";
	        $cant_meses = intval($mes2[1]) - intval($mes1) + 1;
	    }
	    else{
	        $cant_meses = 0;
	        for ($i = $anio1 ; $i <= $anio2 ; $i++){
	            if ($i == $anio1){
	                $cond .= "(( d.anio = ".intval($i).") AND (d.mes >= ".intval($mes1).")) ";
	                $cant_meses += 13 - $mes1;
	            }
	            else{
	                if ($i < $anio2){
	                    $cond .= "OR (d.anio = ".intval($i).") ";
	                    $cant_meses += 12;
	                }
	                else{
	                    $cond .= "OR (d.anio = ".intval($i)." AND (d.mes <= ".intval($mes2).")) ";
	                    $cant_meses += $mes2;
	                }
	            }
	        }
	    }

	    $em = $this->getDoctrine()->getManager();

		$qb = $em->createQueryBuilder();
		$qb->select('d')
		   ->from('AppBundle:Disponibilidad', 'd')
		   ->where($cond)
		   ->orderBy('d.unidad', 'ASC')
		   ->addOrderBy('d.anio', 'ASC')
		   ->addOrderBy('d.mes', 'ASC');
	    if ($unidad)
			$qb->setParameters(array('unidad' => $unidad));
		

	    $query = $qb->getQuery();
	    
	    return array('resultado' => $query->getResult(), 'cant_meses' => $cant_meses);
	}

	public function setearDisponibilidad($unidad, $desde, $hasta){
		//Desmenuzar las fechas desde y hasta en meses (1/1 as 3/3)
		$array_meses = $this->obtenerFechasMeses($desde, $hasta);

		foreach ($array_meses as $am){
			$disponibilidad = $this->existeDisponibilidadUnidad($am['desde'], $unidad);
			//no existe entrada en la tabla de disponibilidades. Se crea una antes de continuar
			if (!$disponibilidad){
				$mes =	$am['desde']->format("m");
				$anio =	$am['desde']->format("Y");
				$disponibilidad = new Disponibilidad();
				$disponibilidad->setUnidad($unidad);
				$disponibilidad->setMes($mes);
				$disponibilidad->setAnio($anio);
				$cadena = $this->generarCadenaDisp($am['desde'], $am['hasta']);
			}
			else{
				$cadena = $disponibilidad -> getCadena();
				$cadena = $this->modificarCadenaDisp($cadena, $am['desde'], $am['hasta'], '1');

			}
			//falló en obtener la cadena
			if ($cadena){
				$disponibilidad->setCadena($cadena);
				$em = $this->getDoctrine()->getManager();
				$em->persist($disponibilidad);
				$em->persist($unidad);
				$em->flush();
			}
			else{
				return false;
			}

		}
		return true;
	}

	public function eliminarDisponibilidad($unidad, $desde, $hasta){
		$array_meses = $this->obtenerFechasMeses($desde, $hasta);
		foreach ($array_meses as $am){
			$disponibilidad = $this->existeDisponibilidadUnidad($am['desde'], $unidad);
			
			if ($disponibilidad){
				$cadena = $this->modificarCadenaDisp($disponibilidad->getCadena(), $am['desde'], $am['hasta'], '0');
				if ($cadena){
					$disponibilidad->setCadena($cadena);
					$em = $this->getDoctrine()->getManager();
					$em->persist($disponibilidad);
					$em->persist($unidad);
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		$em->flush();
		return true;
	}

	public function modificarDisponibilidad($unidad, $desde_or, $hasta_or, $desde_nuevo, $hasta_nuevo){
		$eliminado = $this->eliminarDisponibilidad($unidad, $desde_or, $hasta_or);
		if ($eliminado){
			return $this->setearDisponibilidad($unidad, $desde_nuevo, $hasta_nuevo);
		}
		else
			return false;

	}

	private function generarCadenaDisp($desde, $hasta){
		$anio = $desde->format("Y");
		$mes = $desde->format("m");
		$cadena = '-------------------------------';
		$dias_mes = cal_days_in_month (CAL_GREGORIAN , $mes , $anio);
		for ($i = 0; $i < $dias_mes ; $i++){
			$cadena[$i] = '0';
		}
		//setear los caracteres a disponible
		$cadena = $this->ModificarCadenaDisp($cadena, $desde, $hasta, '1');
		return $cadena;
	}

	private function modificarCadenaDisp($cadena, $desde, $hasta, $caracter){
		// Seteo en 1 por cada espacio en la cadena según fecha
		$aux = $cadena;
		$dia1 = $desde->format("d");
		$dia2 = $hasta->format("d");
		for ($i = $dia1; $i <= $dia2; $i++){
			if ($aux[$i-1] != 'a')
				$aux[$i-1] = $caracter;
			else
				return false;
		}
		return $aux;
	}

	private function obtenerFechasMeses($desde, $hasta){
		$anio1 = $desde->format("Y");
		$anio2 = $hasta->format("Y");

		if ($anio1 == $anio2){
			$mes1 = $desde->format("m");
			$mes2 = $hasta->format("m");
			if ($mes1 == $mes2){
				$ar = array();
				$ar[] = array('desde' => $desde, 'hasta' => $hasta);
				
				return $ar;
			}
			else{
				if ($mes1 < $mes2){
					$ar = $this->iniciarDisponibilidadMeses($desde, $hasta);
					return $ar;
				}
			}
		}
		else{
			if ($anio1 < $anio2){
				// traer todos los meses de acá a fin del primer año
				$ar = $this->iniciarDisponibilidadMeses($desde, new \DateTime($anio1.'-12-31'));
				for ($i = ($anio1 + 1); $i < $anio2 ; $i++){
					$ar = array_merge($ar, $this->iniciarDisponibilidadMeses(
														new \DateTime($i.'-01-01'), 
														new \DateTime($i.'-12-31'))
											);
				}
				$ar = array_merge($ar, $this->iniciarDisponibilidadMeses(
											new \DateTime($anio2.'-01-01'), 
											$hasta)
										);
				
			}
		}
		return ($ar);
	}

	private function iniciarDisponibilidadMeses($desde, $hasta){
		$mes1 = $desde->format("m");
		$mes2 = $hasta->format("m");
		$anio1 = $desde->format("Y");
		$anio2 = $hasta->format("Y");

		$ar = array();
		$ar[] = array('desde' => $desde, 
					'hasta' =>  new \DateTime($anio1.'-'.$mes1.'-'. cal_days_in_month ( CAL_GREGORIAN , $mes1 , $anio1 ))
					);
		for ($i = ($mes1 + 1); $i < $mes2 ; $i++){
			$ar[] = array('desde' => new \DateTime($anio2.'-'.$i.'-01'), 
						'hasta' =>  new \DateTime($anio2.'-'.$i.'-'.cal_days_in_month ( CAL_GREGORIAN , $i , $anio1 ))
						);
		}
		$ar[] = array('desde' => new \DateTime($anio2.'-'.$mes2.'-01'), 'hasta' => $hasta);
		return $ar;
	}

	private function existeDisponibilidadUnidad($desde, $unidad){
		$mes = $desde->format("m");
		$anio = $desde->format("Y");
		
		$em = $this->getDoctrine()->getManager();

		$qb = $em->createQueryBuilder();
		$qb->select('d')
		   ->from('AppBundle:Disponibilidad', 'd')
		   ->where('d.unidad = :unidad AND d.mes = :mes AND d.anio = :anio')
		   ->setParameters(array('anio' => $anio, 'mes' => $mes, 'unidad' => $unidad))
		   ;
	    $query = $qb->getQuery();
		
	    return $query->getSingleResult();
	}

	private function crearFormDisponibilidades(){
		return $this->createFormBuilder()
						->setMethod('POST')
						->add('fecha_desde', 'date', array('widget' => 'single_text'))
						->add('fecha_hasta', 'date', array('label' => 'Fecha Hasta', 'widget' => 'single_text'))
						->add('buscar', 'submit', array('label' => 'BUSCAR COCHERAS', 'attr' =>  array('onclick' => 'buscarPropietarios();')))
						->getForm();
	}

	public function getDisponible(){

	}
}