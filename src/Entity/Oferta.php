<?php

namespace App\Entity;

use App\Repository\OfertaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OfertaRepository::class)
 */
class Oferta
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
     * @ORM\ManyToOne(targetEntity=Comercio::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_comercio;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha_inicio;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha_fin;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $validez;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img_oferta;

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

    public function getIdComercio(): ?Comercio
    {
        return $this->id_comercio;
    }

    public function setIdComercio(?Comercio $id_comercio): self
    {
        $this->id_comercio = $id_comercio;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fecha_inicio;
    }

    public function setFechaInicio(\DateTimeInterface $fecha_inicio): self
    {
        $this->fecha_inicio = $fecha_inicio;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fecha_fin;
    }

    public function setFechaFin(\DateTimeInterface $fecha_fin): self
    {
        $this->fecha_fin = $fecha_fin;

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

    public function getImgOferta(): ?string
    {
        return $this->img_oferta;
    }

    public function setImgOferta(?string $img_oferta): self
    {
        $this->img_oferta = $img_oferta;

        return $this;
    }
}
