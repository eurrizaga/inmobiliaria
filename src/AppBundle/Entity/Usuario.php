<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
* 
* @ORM\Table(name="usuario")
* @ORM\Entity(repositoryClass="AppBundle\Entity\UserRepository")
*/
class Usuario implements UserInterface, \Serializable{
	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;
	
	/**
	* @ORM\Column(type="string", length=20)
    * @Assert\NotBlank()
	*/
	protected $username;

     /**
     * @Assert\NotBlank()
     * @Assert\Length(max = 4096)
     */
    private $plainPassword;

    /**
     * The below length depends on the "algorithm" you use for encoding
     * the password, but this works well with bcrypt
     *
     * @ORM\Column(type="string", length=64)
     */
    private $password;
	
	/**
    * @ORM\Column(type="string", length=1)
    */
    protected $administrar_unidades;
    
    /**
    * @ORM\Column(type="string", length=1)
    */
    protected $alquiler_cocheras;
    
    /**
    * @ORM\Column(type="string", length=1)
    */
    protected $alquiler_departamentos;
    
    /**
    * @ORM\Column(type="string", length=1)
    */
    protected $administrar_operaciones;
    
    /**
    * @ORM\Column(type="string", length=1)
    */
    protected $ver_logs;
    
    /**
    * @ORM\Column(type="string", length=1)
    */
    protected $administrar_usuarios;
	
	/**
	* @ORM\Column(type="string", length=50)
	*/
	protected $nombre;
	
	/**
	* @ORM\Column(type="string", length=50)
	*/
	protected $estado;
	
	/**
	* @ORM\Column(type="integer")
	*/
	protected $caja;

	/**
	* @ORM\OneToMany(targetEntity="Operacion", mappedBy="usuario")
	*/
	protected $operaciones;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->operaciones = new \Doctrine\Common\Collections\ArrayCollection();

        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid(null, true));
    }


    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        return null;
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
     * Set username
     *
     * @param string $username
     *
     * @return Usuario
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    
    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Usuario
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
     * Set estado
     *
     * @param string $estado
     *
     * @return Usuario
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set caja
     *
     * @param integer $caja
     *
     * @return Usuario
     */
    public function setCaja($caja)
    {
        $this->caja = $caja;

        return $this;
    }

    /**
     * Get caja
     *
     * @return integer
     */
    public function getCaja()
    {
        return $this->caja;
    }

    /**
     * Add operacione
     *
     * @param \AppBundle\Entity\Operacion $operacione
     *
     * @return Usuario
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

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }


    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Usuario
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }

    /**
     * Set administrarUnidades
     *
     * @param string $administrarUnidades
     *
     * @return Usuario
     */
    public function setAdministrarUnidades($administrarUnidades)
    {
        $this->administrar_unidades = $administrarUnidades;

        return $this;
    }

    /**
     * Get administrarUnidades
     *
     * @return string
     */
    public function getAdministrarUnidades()
    {
        return $this->administrar_unidades;
    }

    /**
     * Set alquilerCocheras
     *
     * @param string $alquilerCocheras
     *
     * @return Usuario
     */
    public function setAlquilerCocheras($alquilerCocheras)
    {
        $this->alquiler_cocheras = $alquilerCocheras;

        return $this;
    }

    /**
     * Get alquilerCocheras
     *
     * @return string
     */
    public function getAlquilerCocheras()
    {
        return $this->alquiler_cocheras;
    }

    /**
     * Set alquilerDepartamentos
     *
     * @param string $alquilerDepartamentos
     *
     * @return Usuario
     */
    public function setAlquilerDepartamentos($alquilerDepartamentos)
    {
        $this->alquiler_departamentos = $alquilerDepartamentos;

        return $this;
    }

    /**
     * Get alquilerDepartamentos
     *
     * @return string
     */
    public function getAlquilerDepartamentos()
    {
        return $this->alquiler_departamentos;
    }

    /**
     * Set administrarOperaciones
     *
     * @param string $administrarOperaciones
     *
     * @return Usuario
     */
    public function setAdministrarOperaciones($administrarOperaciones)
    {
        $this->administrar_operaciones = $administrarOperaciones;

        return $this;
    }

    /**
     * Get administrarOperaciones
     *
     * @return string
     */
    public function getAdministrarOperaciones()
    {
        return $this->administrar_operaciones;
    }

    /**
     * Set verLogs
     *
     * @param string $verLogs
     *
     * @return Usuario
     */
    public function setVerLogs($verLogs)
    {
        $this->ver_logs = $verLogs;

        return $this;
    }

    /**
     * Get verLogs
     *
     * @return string
     */
    public function getVerLogs()
    {
        return $this->ver_logs;
    }

    /**
     * Set administrarUsuarios
     *
     * @param string $administrarUsuarios
     *
     * @return Usuario
     */
    public function setAdministrarUsuarios($administrarUsuarios)
    {
        $this->administrar_usuarios = $administrarUsuarios;

        return $this;
    }

    /**
     * Get administrarUsuarios
     *
     * @return string
     */
    public function getAdministrarUsuarios()
    {
        return $this->administrar_usuarios;
    }
}
