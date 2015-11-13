<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="edificio")
*/
class Edificio{
	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;

	/**
	* @ORM\Column(type="string", length=50, nullable=true)
	*/
	protected $nombre;

	/**
	* @ORM\Column(type="string", length=50, nullable=true)
	*/
	protected $direccion;
	
	/**
	* @ORM\Column(type="string", length=10, nullable=true)
	*/
	protected $tipo_unidades;

	/**
	* @ORM\Column(type="text", nullable=true)
	*/
	protected $observaciones;

	/**
	* @ORM\OneToMany(targetEntity="Unidad", mappedBy="edificio")
	*/
	protected $unidades;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->unidades = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Edificio
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Edificio
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set tipoUnidades
     *
     * @param string $tipoUnidades
     *
     * @return Edificio
     */
    public function setTipoUnidades($tipoUnidades)
    {
        $this->tipo_unidades = $tipoUnidades;

        return $this;
    }

    /**
     * Get tipoUnidades
     *
     * @return string
     */
    public function getTipoUnidades()
    {
        return $this->tipo_unidades;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Edificio
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Add unidade
     *
     * @param \AppBundle\Entity\Unidad $unidade
     *
     * @return Edificio
     */
    public function addUnidade(\AppBundle\Entity\Unidad $unidade)
    {
        $this->unidades[] = $unidade;

        return $this;
    }

    /**
     * Remove unidade
     *
     * @param \AppBundle\Entity\Unidad $unidade
     */
    public function removeUnidade(\AppBundle\Entity\Unidad $unidade)
    {
        $this->unidades->removeElement($unidade);
    }

    /**
     * Get unidades
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUnidades()
    {
        return $this->unidades;
    }
}
