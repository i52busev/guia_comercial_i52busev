<?php

namespace App\Entity;

use App\Repository\EmpresaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmpresaRepository::class)
 */
class Empresa
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    

    /**
     * @ORM\Column(type="string", length=9)
     */
    private $cif;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $nombre_empresa;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $direccion_empresa;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $localidad_empresa;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $provincia_empresa;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cp_empresa;

    /**
     * @ORM\Column(type="integer")
     */
    private $telefono_empresa;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $actividad_economica;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $web_empresa;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $validez;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logotipo;

    /**
     * @ORM\ManyToOne(targetEntity=Empresario::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_usuario;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCif(): ?string
    {
        return $this->cif;
    }

    public function setCif(string $cif): self
    {
        $this->cif = $cif;

        return $this;
    }

    public function getNombreEmpresa(): ?string
    {
        return $this->nombre_empresa;
    }

    public function setNombreEmpresa(string $nombre_empresa): self
    {
        $this->nombre_empresa = $nombre_empresa;

        return $this;
    }

    public function getDireccionEmpresa(): ?string
    {
        return $this->direccion_empresa;
    }

    public function setDireccionEmpresa(string $direccion_empresa): self
    {
        $this->direccion_empresa = $direccion_empresa;

        return $this;
    }

    public function getLocalidadEmpresa(): ?string
    {
        return $this->localidad_empresa;
    }

    public function setLocalidadEmpresa(string $localidad_empresa): self
    {
        $this->localidad_empresa = $localidad_empresa;

        return $this;
    }

    public function getProvinciaEmpresa(): ?string
    {
        return $this->provincia_empresa;
    }

    public function setProvinciaEmpresa(string $provincia_empresa): self
    {
        $this->provincia_empresa = $provincia_empresa;

        return $this;
    }

    public function getCpEmpresa(): ?int
    {
        return $this->cp_empresa;
    }

    public function setCpEmpresa(?int $cp_empresa): self
    {
        $this->cp_empresa = $cp_empresa;

        return $this;
    }

    public function getTelefonoEmpresa(): ?int
    {
        return $this->telefono_empresa;
    }

    public function setTelefonoEmpresa(int $telefono_empresa): self
    {
        $this->telefono_empresa = $telefono_empresa;

        return $this;
    }

    public function getActividadEconomica(): ?string
    {
        return $this->actividad_economica;
    }

    public function setActividadEconomica(string $actividad_economica): self
    {
        $this->actividad_economica = $actividad_economica;

        return $this;
    }

    public function getWebEmpresa(): ?string
    {
        return $this->web_empresa;
    }

    public function setWebEmpresa(?string $web_empresa): self
    {
        $this->web_empresa = $web_empresa;

        return $this;
    }

    public function getValidez(): ?string
    {
        return $this->validez;
    }

    public function setValidez(string $validez): self
    {
        $this->validez = $validez;

        return $this;
    }

    public function getLogotipo(): ?string
    {
        return $this->logotipo;
    }

    public function setLogotipo(?string $logotipo): self
    {
        $this->logotipo = $logotipo;

        return $this;
    }

    public function getIdEmpresario(): ?Empresario
    {
        return $this->id_usuario;
    }

    public function setIdEmpresario(?Empresario $id_usuario): self
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }
}
