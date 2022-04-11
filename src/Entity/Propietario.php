<?php

namespace App\Entity;

use App\Repository\PropietarioRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PropietarioRepository::class)
 */
class Propietario
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $email_prop;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $tipo_propietario;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getEmailProp(): ?string
    {
        return $this->email_prop;
    }

    public function setEmailProp(?string $email_prop): self
    {
        $this->email_prop = $email_prop;

        return $this;
    }

    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    public function setTelefono(?int $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getTipoPropietario(): ?string
    {
        return $this->tipo_propietario;
    }

    public function setTipoPropietario(?string $tipo_propietario): self
    {
        $this->tipo_propietario = $tipo_propietario;

        return $this;
    }

    public function __toString()
    {
        return $this->nombre;
    }
}
