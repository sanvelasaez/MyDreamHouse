<?php

namespace App\Entity;

use App\Repository\CasaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CasaRepository::class)
 */
class Casa
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $direccion;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=8, nullable=true)
     */
    private $tipo_venta;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $m2;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $precio;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $tipo_casa;

    /**
     * @ORM\ManyToOne(targetEntity=Ciudad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_ciu;

    /**
     * @ORM\ManyToOne(targetEntity=Usuario::class)
     */
    private $id_usu;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $titulo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $habitaciones;

    /**
     * @ORM\OneToMany(targetEntity=Fotos::class, mappedBy="id_casa", orphanRemoval=true)
     */
    private $fotos;

    /**
     * @ORM\ManyToOne(targetEntity=Propietario::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $id_prop;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $banos;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $coordenadas;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $especificaciones;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prioridad;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $extra1;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $extra2;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $activo;

    public function __construct()
    {
        $this->fotos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(?string $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getTipoVenta(): ?string
    {
        return $this->tipo_venta;
    }

    public function setTipoVenta(?string $tipo_venta): self
    {
        $this->tipo_venta = $tipo_venta;

        return $this;
    }

    public function getM2(): ?int
    {
        return $this->m2;
    }

    public function setM2(?int $m2): self
    {
        $this->m2 = $m2;

        return $this;
    }

    public function getPrecio(): ?int
    {
        return $this->precio;
    }

    public function setPrecio(?int $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getTipoCasa(): ?string
    {
        return $this->tipo_casa;
    }

    public function setTipoCasa(?string $tipo_casa): self
    {
        $this->tipo_casa = $tipo_casa;

        return $this;
    }

    public function getIdCiu(): ?Ciudad
    {
        return $this->id_ciu;
    }

    public function setIdCiu(?Ciudad $id_ciu): self
    {
        $this->id_ciu = $id_ciu;

        return $this;
    }

    public function getIdUsu(): ?Usuario
    {
        return $this->id_usu;
    }

    public function setIdUsu(?Usuario $id_usu): self
    {
        $this->id_usu = $id_usu;

        return $this;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(?string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getHabitaciones(): ?int
    {
        return $this->habitaciones;
    }

    public function setHabitaciones(?int $habitaciones): self
    {
        $this->habitaciones = $habitaciones;

        return $this;
    }

    /**
     * @return Collection|Fotos[]
     */
    public function getFotos(): Collection
    {
        return $this->fotos;
    }

    public function addFoto(Fotos $foto): self
    {
        if (!$this->fotos->contains($foto)) {
            $this->fotos[] = $foto;
            $foto->setIdCasa($this);
        }

        return $this;
    }

    public function removeFoto(Fotos $foto): self
    {
        if ($this->fotos->contains($foto)) {
            $this->fotos->removeElement($foto);
            // set the owning side to null (unless already changed)
            if ($foto->getIdCasa() === $this) {
                $foto->setIdCasa(null);
            }
        }

        return $this;
    }

    public function getIdProp(): ?Propietario
    {
        return $this->id_prop;
    }

    public function setIdProp(?Propietario $id_prop): self
    {
        $this->id_prop = $id_prop;

        return $this;
    }

    public function getBanos(): ?int
    {
        return $this->banos;
    }

    public function setBanos(?int $banos): self
    {
        $this->banos = $banos;

        return $this;
    }

    public function getCoordenadas(): ?string
    {
        return $this->coordenadas;
    }

    public function setCoordenadas(?string $coordenadas): self
    {
        $this->coordenadas = $coordenadas;

        return $this;
    }

    public function getEspecificaciones(): ?string
    {
        return $this->especificaciones;
    }

    public function setEspecificaciones(?string $especificaciones): self
    {
        $this->especificaciones = $especificaciones;

        return $this;
    }

    public function getPrioridad(): ?int
    {
        return $this->prioridad;
    }

    public function setPrioridad(?int $prioridad): self
    {
        $this->prioridad = $prioridad;

        return $this;
    }

    public function getExtra1(): ?string
    {
        return $this->extra1;
    }

    public function setExtra1(?string $extra1): self
    {
        $this->extra1 = $extra1;

        return $this;
    }

    public function getExtra2(): ?string
    {
        return $this->extra2;
    }

    public function setExtra2(?string $extra2): self
    {
        $this->extra2 = $extra2;

        return $this;
    }

    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(?bool $activo): self
    {
        $this->activo = $activo;

        return $this;
    }

    public function __toString()
    {
        return $this->titulo;
    }
}
