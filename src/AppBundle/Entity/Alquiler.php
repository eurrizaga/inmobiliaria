<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
*/
class Alquiler extends Operacion{
	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;
	
	/**
	* @ORM\Column(type="date", nullable=true)
	*/
	protected $fecha_desde;
	
	/**
	* @ORM\Column(type="date", nullable=true)
	*/
	protected $fecha_hasta;
	
	/**
	* @ORM\Column(type="date", nullable=true)
	*/
	protected $promesa_fecha;


    /**
     * Set fechaDesde
     *
     * @param \DateTime $fechaDesde
     *
     * @return Alquiler
     */
    public function setFechaDesde($fechaDesde)
    {
        $this->fecha_desde = $fechaDesde;

        return $this;
    }

    /**
     * Get fechaDesde
     *
     * @return \DateTime
     */
    public function getFechaDesde()
    {
        return $this->fecha_desde;
    }

    /**
     * Set fechaHasta
     *
     * @param \DateTime $fechaHasta
     *
     * @return Alquiler
     */
    public function setFechaHasta($fechaHasta)
    {
        $this->fecha_hasta = $fechaHasta;

        return $this;
    }

    /**
     * Get fechaHasta
     *
     * @return \DateTime
     */
    public function getFechaHasta()
    {
        return $this->fecha_hasta;
    }
}
