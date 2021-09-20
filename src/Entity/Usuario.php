<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UsuarioRepository::class)
 */
class Usuario implements UserInterface, PasswordAuthenticatedUserInterface
{
    const ROLE_ADMINISTRADOR = 'ROLE_ADMINISTRADOR';
    const ROLE_EMPRESARIO = 'ROLE_EMPRESARIO';
    const ROLE_CLIENTE = 'ROLE_CLIENTE';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $apellidos;

    /**
     * @ORM\Column(type="integer")
     */
    private $telefono;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha_alta;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $validez;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    public function setTelefono(int $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getFechaAlta(): ?\DateTimeInterface
    {
        return $this->fecha_alta;
    }

    public function setFechaAlta(\DateTimeInterface $fecha_alta): self
    {
        $this->fecha_alta = $fecha_alta;

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

    public function esAdministrador(): bool //Comprueba que el usuario sea un Administrador
    {
        return in_array(self::ROLE_ADMINISTRADOR, $this->getRoles());
    }

    public function esAdministradorValido(): bool //Comprueba que el usuario sea un Administrador validado
    {
        return (in_array(self::ROLE_ADMINISTRADOR, $this->getRoles()) && ($this->getValidez() == 'sí'));
    }

    public function esEmpresario(): bool //Comprueba que el usuario sea un Empresario
    {
        return in_array(self::ROLE_EMPRESARIO, $this->getRoles());
    }

    public function esEmpresarioValido(): bool //Comprueba que el usuario sea un Empresario validado
    {
        return (in_array(self::ROLE_EMPRESARIO, $this->getRoles()) && ($this->getValidez() == 'sí'));
    }

    public function esCliente(): bool //Comprueba que el usuario sea un Cliente
    {
        return in_array(self::ROLE_CLIENTE, $this->getRoles());
    }

    public function esClienteValido(): bool //Comprueba que el usuario sea un Cliente validado
    {
        return (in_array(self::ROLE_CLIENTE, $this->getRoles()) && ($this->getValidez() == 'sí'));
    }

}
