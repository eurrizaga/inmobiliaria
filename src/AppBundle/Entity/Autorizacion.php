<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="autorizacion")
*/

class Autorizacion{
	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;
	
	/**
	* @ORM\ManyToOne(targetEntity="Unidad")
	* @ORM\JoinColumn(name="unidad_id", referencedColumnName="id")
    **/
	protected $unidad;

	/**
	* @ORM\Column(type="date")
	*/
	protected $fecha_autorizacion;

	/**
	* @ORM\Column(type="date")
	*/
	protected $fecha_desde;

	/**
	* @ORM\Column(type="date")
	*/
	protected $fecha_hasta;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fechaAutorizacion
     *
     * @param \DateTime $fechaAutorizacion
     *
     * @return Autorizacion
     */
    public function setFechaAutorizacion($fechaAutorizacion)
    {
        $this->fecha_autorizacion = $fechaAutorizacion;

        return $this;
    }

    /**
     * Get fechaAutorizacion
     *
     * @return \DateTime
     */
    public function getFechaAutorizacion()
    {
        return $this->fecha_autorizacion;
    }

    /**
     * Set fechaDesde
     *
     * @param \DateTime $fechaDesde
     *
     * @return Autorizacion
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
     * @return Autorizacion
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

    /**
     * Set unidad
     *
     * @param \AppBundle\Entity\Unidad $unidad
     *
     * @return Autorizacion
     */
    public function setUnidad(\AppBundle\Entity\Unidad $unidad = null)
    {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * Get unidad
     *
     * @return \AppBundle\Entity\Unidad
     */
    public function getUnidad()
    {
        return $this->unidad;
    }
}
