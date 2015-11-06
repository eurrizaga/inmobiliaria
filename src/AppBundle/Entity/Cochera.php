<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
*/
class Cochera extends Unidad{
	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;
	
	/**
	* @ORM\Column(type="integer", nullable=true)
	*/
	protected $numero;
	
	/**
	* @ORM\Column(type="string", length=2, nullable=true)
	*/
	protected $categoria;
	
	/**
	* @ORM\Column(type="integer", nullable=true)
	*/
	protected $distancia_ascensor;
	
	/**
	* @ORM\Column(type="integer", nullable=true)
	*/
	protected $distancia_escalera_caracol;
	
	/**
	* @ORM\Column(type="integer", nullable=true)
	*/
	protected $distancia_escalera_bristol;
	
	/**
	* @ORM\Column(type="integer", nullable=true)
	*/
	protected $distancia_escalera_izq;
	
	/**
	* @ORM\Column(type="integer", nullable=true)
	*/
	protected $distancia_escalera_der;
	
	/**
	* @ORM\Column(type="decimal", scale=2, nullable=true)
	*/
	protected $ancho;
	
	/**
	* @ORM\Column(type="decimal", scale=2, nullable=true)
	*/
	protected $largo;
	
	/**
	* @ORM\Column(type="integer", scale=2, nullable=true)
	*/
	protected $subsuelo;
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->disponibilidades = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set numero
     *
     * @param integer $numero
     *
     * @return Cochera
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set categoria
     *
     * @param string $categoria
     *
     * @return Cochera
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return string
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set distanciaAscensor
     *
     * @param integer $distanciaAscensor
     *
     * @return Cochera
     */
    public function setDistanciaAscensor($distanciaAscensor)
    {
        $this->distancia_ascensor = $distanciaAscensor;

        return $this;
    }

    /**
     * Get distanciaAscensor
     *
     * @return integer
     */
    public function getDistanciaAscensor()
    {
        return $this->distancia_ascensor;
    }

    /**
     * Set distanciaEscaleraCaracol
     *
     * @param integer $distanciaEscaleraCaracol
     *
     * @return Cochera
     */
    public function setDistanciaEscaleraCaracol($distanciaEscaleraCaracol)
    {
        $this->distancia_escalera_caracol = $distanciaEscaleraCaracol;

        return $this;
    }

    /**
     * Get distanciaEscaleraCaracol
     *
     * @return integer
     */
    public function getDistanciaEscaleraCaracol()
    {
        return $this->distancia_escalera_caracol;
    }

    /**
     * Set distanciaEscaleraBristol
     *
     * @param integer $distanciaEscaleraBristol
     *
     * @return Cochera
     */
    public function setDistanciaEscaleraBristol($distanciaEscaleraBristol)
    {
        $this->distancia_escalera_bristol = $distanciaEscaleraBristol;

        return $this;
    }

    /**
     * Get distanciaEscaleraBristol
     *
     * @return integer
     */
    public function getDistanciaEscaleraBristol()
    {
        return $this->distancia_escalera_bristol;
    }

    /**
     * Set distanciaEscaleraIzq
     *
     * @param integer $distanciaEscaleraIzq
     *
     * @return Cochera
     */
    public function setDistanciaEscaleraIzq($distanciaEscaleraIzq)
    {
        $this->distancia_escalera_izq = $distanciaEscaleraIzq;

        return $this;
    }

    /**
     * Get distanciaEscaleraIzq
     *
     * @return integer
     */
    public function getDistanciaEscaleraIzq()
    {
        return $this->distancia_escalera_izq;
    }

    /**
     * Set distanciaEscaleraDer
     *
     * @param integer $distanciaEscaleraDer
     *
     * @return Cochera
     */
    public function setDistanciaEscaleraDer($distanciaEscaleraDer)
    {
        $this->distancia_escalera_der = $distanciaEscaleraDer;

        return $this;
    }

    /**
     * Get distanciaEscaleraDer
     *
     * @return integer
     */
    public function getDistanciaEscaleraDer()
    {
        return $this->distancia_escalera_der;
    }

    /**
     * Set ancho
     *
     * @param string $ancho
     *
     * @return Cochera
     */
    public function setAncho($ancho)
    {
        $this->ancho = $ancho;

        return $this;
    }

    /**
     * Get ancho
     *
     * @return string
     */
    public function getAncho()
    {
        return $this->ancho;
    }

    /**
     * Set largo
     *
     * @param string $largo
     *
     * @return Cochera
     */
    public function setLargo($largo)
    {
        $this->largo = $largo;

        return $this;
    }

    /**
     * Get largo
     *
     * @return string
     */
    public function getLargo()
    {
        return $this->largo;
    }

    /**
     * Set subsuelo
     *
     * @param integer $subsuelo
     *
     * @return Cochera
     */
    public function setSubsuelo($subsuelo)
    {
        $this->subsuelo = $subsuelo;

        return $this;
    }

    /**
     * Get subsuelo
     *
     * @return integer
     */
    public function getSubsuelo()
    {
        return $this->subsuelo;
    }

    /**
     * Add disponibilidade
     *
     * @param \AppBundle\Entity\Disponibilidad $disponibilidade
     *
     * @return Cochera
     */
    public function addDisponibilidade(\AppBundle\Entity\Disponibilidad $disponibilidade)
    {
        $this->disponibilidades[] = $disponibilidade;

        return $this;
    }

    /**
     * Remove disponibilidade
     *
     * @param \AppBundle\Entity\Disponibilidad $disponibilidade
     */
    public function removeDisponibilidade(\AppBundle\Entity\Disponibilidad $disponibilidade)
    {
        $this->disponibilidades->removeElement($disponibilidade);
    }

    /**
     * Get disponibilidades
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDisponibilidades()
    {
        return $this->disponibilidades;
    }
}
