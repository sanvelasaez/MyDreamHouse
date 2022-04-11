<?php

namespace App\Entity;

use App\Repository\FotosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FotosRepository::class)
 */
class Fotos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ruta;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $principal;

    /**
     * @ORM\ManyToOne(targetEntity=Casa::class, inversedBy="fotos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_casa;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRuta(): ?string
    {
        return $this->ruta;
    }

    public function setRuta(?string $ruta): self
    {
        $this->ruta = $ruta;

        return $this;
    }

    public function getPrincipal(): ?int
    {
        return $this->principal;
    }

    public function setPrincipal(?int $principal): self
    {
        $this->principal = $principal;

        return $this;
    }

    public function getIdCasa(): ?Casa
    {
        return $this->id_casa;
    }

    public function setIdCasa(?Casa $id_casa): self
    {
        $this->id_casa = $id_casa;

        return $this;
    }

    public function __toString()
    {
        return $this->ruta;
    }
}
