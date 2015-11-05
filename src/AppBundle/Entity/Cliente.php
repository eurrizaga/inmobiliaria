<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"cliente" = "Cliente", "propietario" = "Propietario"})
 */
class Cliente{

	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;
	
	/**
	* @ORM\Column(type="string", length=100, nullable=true)
	*/
	protected $apellido;
	
	/**
	* @ORM\Column(type="string", length=100, nullable=true)
	*/
	protected $nombres;
	
	/**
	* @ORM\Column(type="string", length=5, nullable=true)
	*/
	protected $tipodoc;
	
	/**
	* @ORM\Column(type="integer", nullable=true)
	*/
	protected $nrodoc;
	
	/**
	* @ORM\Column(type="string", length=100, nullable=true)
	*/
	protected $direccion;
	
	/**
	* @ORM\Column(type="string", length=30, nullable=true)
	*/
	protected $localidad;

	/**
	* @ORM\Column(type="integer", nullable=true)
	*/
	protected $codigopostal;
	
	/**
	* @ORM\Column(type="string", length=30, nullable=true)
	*/
	protected $provincia;
	
	/**
	* @ORM\Column(type="string", length=30, nullable=true)
	*/
	protected $pais;
	
	/**
	* @ORM\Column(type="string", length=20, nullable=true)
	*/
	protected $telefonofijo;
	
	/**
	* @ORM\Column(type="string", length=20, nullable=true)
	*/
	protected $telefonomovil;
	
	/**
	* @ORM\Column(type="string", length=50, nullable=true)
	*/
	protected $email;
	
	/**
	* @ORM\Column(type="date", nullable=true)
	*/
	protected $fechaalta;

	/**
	* @ORM\OneToMany(targetEntity="Operacion", mappedBy="category")
	*/
	protected $operaciones;
	
	/**
	* @ORM\Column(type="date", nullable=true)
	*/
	protected $fechaultimaop;
	
	/**
	* @ORM\Column(type="text", nullable=true)
	*/
	protected $observaciones;
	
	/**
	* @ORM\Column(type="boolean", nullable=true)
	*/
	protected $problematico;
	
	/**
	* @ORM\Column(type="string", length=5, nullable=true)
	*/
	protected $iva;


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
     * Set apellido
     *
     * @param string $apellido
     *
     * @return Cliente
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     *
     * @return Cliente
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set tipodoc
     *
     * @param string $tipodoc
     *
     * @return Cliente
     */
    public function setTipodoc($tipodoc)
    {
        $this->tipodoc = $tipodoc;

        return $this;
    }

    /**
     * Get tipodoc
     *
     * @return string
     */
    public function getTipodoc()
    {
        return $this->tipodoc;
    }

    /**
     * Set nrodoc
     *
     * @param integer $nrodoc
     *
     * @return Cliente
     */
    public function setNrodoc($nrodoc)
    {
        $this->nrodoc = $nrodoc;

        return $this;
    }

    /**
     * Get nrodoc
     *
     * @return integer
     */
    public function getNrodoc()
    {
        return $this->nrodoc;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Cliente
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
     * Set localidad
     *
     * @param string $localidad
     *
     * @return Cliente
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return string
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set codigopostal
     *
     * @param integer $codigopostal
     *
     * @return Cliente
     */
    public function setCodigopostal($codigopostal)
    {
        $this->codigopostal = $codigopostal;

        return $this;
    }

    /**
     * Get codigopostal
     *
     * @return integer
     */
    public function getCodigopostal()
    {
        return $this->codigopostal;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     *
     * @return Cliente
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set pais
     *
     * @param string $pais
     *
     * @return Cliente
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set telefonofijo
     *
     * @param string $telefonofijo
     *
     * @return Cliente
     */
    public function setTelefonofijo($telefonofijo)
    {
        $this->telefonofijo = $telefonofijo;

        return $this;
    }

    /**
     * Get telefonofijo
     *
     * @return string
     */
    public function getTelefonofijo()
    {
        return $this->telefonofijo;
    }

    /**
     * Set telefonomovil
     *
     * @param string $telefonomovil
     *
     * @return Cliente
     */
    public function setTelefonomovil($telefonomovil)
    {
        $this->telefonomovil = $telefonomovil;

        return $this;
    }

    /**
     * Get telefonomovil
     *
     * @return string
     */
    public function getTelefonomovil()
    {
        return $this->telefonomovil;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Cliente
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set fechaalta
     *
     * @param \DateTime $fechaalta
     *
     * @return Cliente
     */
    public function setFechaalta($fechaalta)
    {
        $this->fechaalta = $fechaalta;

        return $this;
    }

    /**
     * Get fechaalta
     *
     * @return \DateTime
     */
    public function getFechaalta()
    {
        return $this->fechaalta;
    }

    /**
     * Set cantidadoperaciones
     *
     * @param integer $cantidadoperaciones
     *
     * @return Cliente
     */
    public function setCantidadoperaciones($cantidadoperaciones)
    {
        $this->cantidadoperaciones = $cantidadoperaciones;

        return $this;
    }

    /**
     * Get cantidadoperaciones
     *
     * @return integer
     */
    public function getCantidadoperaciones()
    {
        return $this->cantidadoperaciones;
    }

    /**
     * Set fechaultimaop
     *
     * @param \DateTime $fechaultimaop
     *
     * @return Cliente
     */
    public function setFechaultimaop($fechaultimaop)
    {
        $this->fechaultimaop = $fechaultimaop;

        return $this;
    }

    /**
     * Get fechaultimaop
     *
     * @return \DateTime
     */
    public function getFechaultimaop()
    {
        return $this->fechaultimaop;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Cliente
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
     * Set problematico
     *
     * @param boolean $problematico
     *
     * @return Cliente
     */
    public function setProblematico($problematico)
    {
        $this->problematico = $problematico;

        return $this;
    }

    /**
     * Get problematico
     *
     * @return boolean
     */
    public function getProblematico()
    {
        return $this->problematico;
    }

    /**
     * Set iva
     *
     * @param string $iva
     *
     * @return Cliente
     */
    public function setIva($iva)
    {
        $this->iva = $iva;

        return $this;
    }

    /**
     * Get iva
     *
     * @return string
     */
    public function getIva()
    {
        return $this->iva;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->operaciones = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add operacione
     *
     * @param \AppBundle\Entity\Operacion $operacione
     *
     * @return Cliente
     */
    public function addOperacione(\AppBundle\Entity\Operacion $operacione)
    {
        $this->operaciones[] = $operacione;

        return $this;
    }

    /**
     * Remove operacione
     *
     * @param \AppBundle\Entity\Operacion $operacione
     */
    public function removeOperacione(\AppBundle\Entity\Operacion $operacione)
    {
        $this->operaciones->removeElement($operacione);
    }

    /**
     * Get operaciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOperaciones()
    {
        return $this->operaciones;
    }
}
