<?php

namespace App\Entity;

use App\Repository\ComercioRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComercioRepository::class)
 */
class Comercio
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
    private $nombre_comercio;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $direccion_comercio;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $codigo_postal;

    /**
     * @ORM\Column(type="integer")
     */
    private $telefono_comercio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $web_comercio;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $validez;

    /**
     * @ORM\ManyToOne(targetEntity=Empresa::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_empresa;

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

    public function getNombreComercio(): ?string
    {
        return $this->nombre_comercio;
    }

    public function setNombreComercio(string $nombre_comercio): self
    {
        $this->nombre_comercio = $nombre_comercio;

        return $this;
    }

    public function getDireccionComercio(): ?string
    {
        return $this->direccion_comercio;
    }

    public function setDireccionComercio(string $direccion_comercio): self
    {
        $this->direccion_comercio = $direccion_comercio;

        return $this;
    }

    public function getCodigoPostal(): ?int
    {
        return $this->codigo_postal;
    }

    public function setCodigoPostal(?int $codigo_postal): self
    {
        $this->codigo_postal = $codigo_postal;

        return $this;
    }

    public function getTelefonoComercio(): ?int
    {
        return $this->telefono_comercio;
    }

    public function setTelefonoComercio(int $telefono_comercio): self
    {
        $this->telefono_comercio = $telefono_comercio;

        return $this;
    }

    public function getWebComercio(): ?string
    {
        return $this->web_comercio;
    }

    public function setWebComercio(?string $web_comercio): self
    {
        $this->web_comercio = $web_comercio;

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

    public function getIdEmpresa(): ?Empresa
    {
        return $this->id_empresa;
    }

    public function setIdEmpresa(?Empresa $id_empresa): self
    {
        $this->id_empresa = $id_empresa;

        return $this;
    }
}
