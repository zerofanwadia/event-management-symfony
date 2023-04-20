<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Lieu $lieu = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: Reserve::class, orphanRemoval: true)]
    private Collection $reserves;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: Clent::class, orphanRemoval: true)]
    private Collection $clents;

    public function __construct()
    {
        $this->reserves = new ArrayCollection();
        $this->clents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Reserve>
     */
    public function getReserves(): Collection
    {
        return $this->reserves;
    }

    public function addReserf(Reserve $reserf): self
    {
        if (!$this->reserves->contains($reserf)) {
            $this->reserves->add($reserf);
            $reserf->setEvent($this);
        }

        return $this;
    }

    public function removeReserf(Reserve $reserf): self
    {
        if ($this->reserves->removeElement($reserf)) {
            // set the owning side to null (unless already changed)
            if ($reserf->getEvent() === $this) {
                $reserf->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Clent>
     */
    public function getClents(): Collection
    {
        return $this->clents;
    }

    public function addClent(Clent $clent): self
    {
        if (!$this->clents->contains($clent)) {
            $this->clents->add($clent);
            $clent->setEvent($this);
        }

        return $this;
    }

    public function removeClent(Clent $clent): self
    {
        if ($this->clents->removeElement($clent)) {
            // set the owning side to null (unless already changed)
            if ($clent->getEvent() === $this) {
                $clent->setEvent(null);
            }
        }

        return $this;
    }
    
}