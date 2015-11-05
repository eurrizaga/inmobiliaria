<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="unidad")
*/
class Unidad{
	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;

	/**
	* @ORM\ManyToOne(targetEntity="Edificio", inversedBy="edificios")
	* @ORM\JoinColumn(name="edificio_id", referencedColumnName="id")
     **/
	protected $edificio;

	/**
	* @ORM\ManyToOne(targetEntity="Propietario", inversedBy="propietarios")
	* @ORM\JoinColumn(name="propietario_id", referencedColumnName="id")
     **/
	protected $propietario;

	/**
	* @ORM\Column(type="string", length=5, nullable=true)
	*/
	protected $op_habilitadas;

	/**
	* @ORM\Column(type="string", length=20, nullable=true)
	*/
	protected $codigo;

	/**
	* @ORM\Column(type="integer", nullable=true)
	*/
	protected $num_carpeta;

	/**
	* @ORM\Column(type="date")
	*/
	protected $fecha_autorizacion;
	
	/**
	* @ORM\Column(type="text", nullable=true)
	*/
	protected $detalles;

	/**
	* @ORM\Column(type="string", length=20, nullable=true)
	*/
	protected $periodo_sugerido;

	/**
	* @ORM\Column(type="date", nullable=true)
	*/
	protected $fecha_ultima_op;



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
     * Set opHabilitadas
     *
     * @param string $opHabilitadas
     *
     * @return Unidad
     */
    public function setOpHabilitadas($opHabilitadas)
    {
        $this->op_habilitadas = $opHabilitadas;

        return $this;
    }

    /**
     * Get opHabilitadas
     *
     * @return string
     */
    public function getOpHabilitadas()
    {
        return $this->op_habilitadas;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     *
     * @return Unidad
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set numCarpeta
     *
     * @param integer $numCarpeta
     *
     * @return Unidad
     */
    public function setNumCarpeta($numCarpeta)
    {
        $this->num_carpeta = $numCarpeta;

        return $this;
    }

    /**
     * Get numCarpeta
     *
     * @return integer
     */
    public function getNumCarpeta()
    {
        return $this->num_carpeta;
    }

    /**
     * Set fechaAutorizacion
     *
     * @param \DateTime $fechaAutorizacion
     *
     * @return Unidad
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
     * Set detalles
     *
     * @param string $detalles
     *
     * @return Unidad
     */
    public function setDetalles($detalles)
    {
        $this->detalles = $detalles;

        return $this;
    }

    /**
     * Get detalles
     *
     * @return string
     */
    public function getDetalles()
    {
        return $this->detalles;
    }

    /**
     * Set periodoSugerido
     *
     * @param string $periodoSugerido
     *
     * @return Unidad
     */
    public function setPeriodoSugerido($periodoSugerido)
    {
        $this->periodo_sugerido = $periodoSugerido;

        return $this;
    }

    /**
     * Get periodoSugerido
     *
     * @return string
     */
    public function getPeriodoSugerido()
    {
        return $this->periodo_sugerido;
    }

    /**
     * Set fechaUltimaOp
     *
     * @param \DateTime $fechaUltimaOp
     *
     * @return Unidad
     */
    public function setFechaUltimaOp($fechaUltimaOp)
    {
        $this->fecha_ultima_op = $fechaUltimaOp;

        return $this;
    }

    /**
     * Get fechaUltimaOp
     *
     * @return \DateTime
     */
    public function getFechaUltimaOp()
    {
        return $this->fecha_ultima_op;
    }

    /**
     * Set edificio
     *
     * @param \AppBundle\Entity\Edificio $edificio
     *
     * @return Unidad
     */
    public function setEdificio(\AppBundle\Entity\Edificio $edificio = null)
    {
        $this->edificio = $edificio;

        return $this;
    }

    /**
     * Get edificio
     *
     * @return \AppBundle\Entity\Edificio
     */
    public function getEdificio()
    {
        return $this->edificio;
    }

    /**
     * Set propietario
     *
     * @param \AppBundle\Entity\Propietario $propietario
     *
     * @return Unidad
     */
    public function setPropietario(\AppBundle\Entity\Propietario $propietario = null)
    {
        $this->propietario = $propietario;

        return $this;
    }

    /**
     * Get propietario
     *
     * @return \AppBundle\Entity\Propietario
     */
    public function getPropietario()
    {
        return $this->propietario;
    }
}