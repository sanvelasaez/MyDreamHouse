<?php

namespace App\Entity;

use App\Repository\CiudadRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass=CiudadRepository::class)
 * @UniqueEntity(fields="nombre_ciudad", message="Ya existe esa ciudad!!!")
 */
class Ciudad
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    protected $nombre_ciudad;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreCiudad(): ?string
    {
        return $this->nombre_ciudad;
    }

    public function setNombreCiudad(string $nombre_ciudad): self
    {
        $this->nombre_ciudad = $nombre_ciudad;

        return $this;
    }

    public function __toString()
    {
        return $this->nombre_ciudad;
    }
}
