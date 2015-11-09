<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
* @ORM\Entity
*/
class Propietario extends Cliente{
	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;
	
	/**
	* @ORM\Column(type="integer", nullable=true)
    * @Assert\Type(
     *     type="numeric",
     *     message="El valor {{ value }} debe ser numérico."
     * )
	*/
	protected $cuit;
	

	protected $metodo_pago_preferido;
	
	/**
	* @ORM\Column(type="integer", nullable=true)
    * @Assert\Type(
     *     type="numeric",
     *     message="El valor {{ value }} debe ser numérico."
     * )
	*/
	protected $cbu;
	
	/**
	* @ORM\Column(type="string", length=50, nullable=true)
	*/
	protected $banco;

	/**
	* @ORM\Column(type="string", length=10, nullable=true)
	*/
	protected $sucursal;

	/**
	* @ORM\Column(type="string", length=10, nullable=true)
    */
	protected $mailing;
	
	/**
	* @ORM\Column(type="integer", nullable=true)
    * @Assert\Type(
     *     type="numeric",
     *     message="El valor {{ value }} debe ser numérico."
     * )
	*/
	protected $num_carpeta;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->operaciones = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set cuit
     *
     * @param integer $cuit
     *
     * @return Propietario
     */
    public function setCuit($cuit)
    {
        $this->cuit = $cuit;

        return $this;
    }

    

    /**
     * Get cuit
     *
     * @return integer
     */
    public function getCuit()
    {
        return $this->cuit;
    }

    /**
     * Set cbu
     *
     * @param integer $cbu
     *
     * @return Propietario
     */
    public function setCbu($cbu)
    {
        $this->cbu = $cbu;

        return $this;
    }

    /**
     * Get cbu
     *
     * @return integer
     */
    public function getCbu()
    {
        return $this->cbu;
    }

    /**
     * Set banco
     *
     * @param string $banco
     *
     * @return Propietario
     */
    public function setBanco($banco)
    {
        $this->banco = $banco;

        return $this;
    }

    /**
     * Get banco
     *
     * @return string
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * Set sucursal
     *
     * @param string $sucursal
     *
     * @return Propietario
     */
    public function setSucursal($sucursal)
    {
        $this->sucursal = $sucursal;

        return $this;
    }

    /**
     * Get sucursal
     *
     * @return string
     */
    public function getSucursal()
    {
        return $this->sucursal;
    }

    /**
     * Set mailing
     *
     * @param string $mailing
     *
     * @return Propietario
     */
    public function setMailing($mailing)
    {
        $this->mailing = $mailing;

        return $this;
    }

    /**
     * Get mailing
     *
     * @return string
     */
    public function getMailing()
    {
        return $this->mailing;
    }

    /**
     * Set numCarpeta
     *
     * @param integer $numCarpeta
     *
     * @return Propietario
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
     * Add operacione
     *
     * @param \AppBundle\Entity\Operacion $operacione
     *
     * @return Propietario
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
