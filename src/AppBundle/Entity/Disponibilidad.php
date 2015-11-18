<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="disponibilidad")
*/
Class Disponibilidad{
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
	* @ORM\Column(type="integer", nullable=true)
	*/
	protected $mes;
	
	/**
	* @ORM\Column(type="integer", nullable=true)
	*/
	protected $anio;
	
	/**
	* @ORM\Column(type="string", length=31, nullable=true)
	*/
	protected $cadena;

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
     * Set mes
     *
     * @param integer $mes
     *
     * @return Disponibilidad
     */
    public function setMes($mes)
    {
        $this->mes = $mes;

        return $this;
    }

    /**
     * Get mes
     *
     * @return integer
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * Set anio
     *
     * @param integer $anio
     *
     * @return Disponibilidad
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return integer
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set cadena
     *
     * @param string $cadena
     *
     * @return Disponibilidad
     */
    public function setCadena($cadena)
    {
        $this->cadena = $cadena;

        return $this;
    }

    /**
     * Get cadena
     *
     * @return string
     */
    public function getCadena()
    {
        return $this->cadena;
    }

    /**
     * Set unidad
     *
     * @param \AppBundle\Entity\Unidad $unidad
     *
     * @return Disponibilidad
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
