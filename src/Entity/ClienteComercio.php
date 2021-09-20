<?php

namespace App\Entity;

use App\Repository\ClienteComercioRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClienteComercioRepository::class)
 */
class ClienteComercio
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Cliente::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_usuario;

    /**
     * @ORM\ManyToOne(targetEntity=Comercio::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $cif;

    /**
     * @ORM\ManyToOne(targetEntity=Comercio::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_comercio;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUsuario(): ?Cliente
    {
        return $this->id_usuario;
    }

    public function setIdUsuario(Cliente $id_usuario): self
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }

    public function getCif(): ?Comercio
    {
        return $this->cif;
    }

    public function setCif(?Comercio $cif): self
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
}
