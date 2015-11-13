<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"operacion" = "Operacion", "alquiler" = "Alquiler"})
 */


class Operacion{

	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;
	
	/**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="clientes")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     **/
	protected $cliente;
	
	/**
	* @ORM\ManyToOne(targetEntity="Usuario", inversedBy="usuarios")
	* @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     **/
	protected $usuario;
	
	/**
	* @ORM\ManyToOne(targetEntity="Unidad", inversedBy="unidades")
	* @ORM\JoinColumn(name="unidad_id", referencedColumnName="id")
     **/
	protected $unidad;
	
	/**
	* @ORM\Column(type="datetime", nullable=true)
	*/
	protected $fecha_hora;
	
	/**
	* @ORM\Column(type="decimal", scale=2, nullable=true)
	*/
	protected $comision;
	
	/**
	* @ORM\Column(type="text", nullable=true)
	*/
	protected $observaciones;
	
	/**
	* @ORM\Column(type="date", nullable=true)
	*/
	protected $promesa_fecha;
	
	/**
	* @ORM\Column(type="decimal", scale=2, nullable=true)
	*/
	protected $monto_total;
	
	/**
	* @ORM\Column(type="decimal", scale=2, nullable=true)
	*/
	protected $monto_abonado;
	
	/**
	* @ORM\Column(type="decimal", scale=2, nullable=true)
	*/
	protected $monto_recargo;
	

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
     * Set fechaHora
     *
     * @param \DateTime $fechaHora
     *
     * @return Operacion
     */
    public function setFechaHora($fechaHora)
    {
        $this->fecha_hora = $fechaHora;

        return $this;
    }

    /**
     * Get fechaHora
     *
     * @return \DateTime
     */
    public function getFechaHora()
    {
        return $this->fecha_hora;
    }

    /**
     * Set comision
     *
     * @param string $comision
     *
     * @return Operacion
     */
    public function setComision($comision)
    {
        $this->comision = $comision;

        return $this;
    }

    /**
     * Get comision
     *
     * @return string
     */
    public function getComision()
    {
        return $this->comision;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Operacion
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
     * Set promesaFecha
     *
     * @param \DateTime $promesaFecha
     *
     * @return Operacion
     */
    public function setPromesaFecha($promesaFecha)
    {
        $this->promesa_fecha = $promesaFecha;

        return $this;
    }

    /**
     * Get promesaFecha
     *
     * @return \DateTime
     */
    public function getPromesaFecha()
    {
        return $this->promesa_fecha;
    }

    /**
     * Set montoTotal
     *
     * @param string $montoTotal
     *
     * @return Operacion
     */
    public function setMontoTotal($montoTotal)
    {
        $this->monto_total = $montoTotal;

        return $this;
    }

    /**
     * Get montoTotal
     *
     * @return string
     */
    public function getMontoTotal()
    {
        return $this->monto_total;
    }

    /**
     * Set montoAbonado
     *
     * @param string $montoAbonado
     *
     * @return Operacion
     */
    public function setMontoAbonado($montoAbonado)
    {
        $this->monto_abonado = $montoAbonado;

        return $this;
    }

    /**
     * Get montoAbonado
     *
     * @return string
     */
    public function getMontoAbonado()
    {
        return $this->monto_abonado;
    }

    /**
     * Set montoRecargo
     *
     * @param string $montoRecargo
     *
     * @return Operacion
     */
    public function setMontoRecargo($montoRecargo)
    {
        $this->monto_recargo = $montoRecargo;

        return $this;
    }

    /**
     * Get montoRecargo
     *
     * @return string
     */
    public function getMontoRecargo()
    {
        return $this->monto_recargo;
    }

    /**
     * Set cliente
     *
     * @param \AppBundle\Entity\Cliente $cliente
     *
     * @return Operacion
     */
    public function setCliente(\AppBundle\Entity\Cliente $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \AppBundle\Entity\Cliente
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set usuario
     *
     * @param \AppBundle\Entity\Usuario $usuario
     *
     * @return Operacion
     */
    public function setUsuario(\AppBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set unidad
     *
     * @param \AppBundle\Entity\Unidad $unidad
     *
     * @return Operacion
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
