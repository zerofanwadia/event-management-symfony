<?php

namespace App\Entity;

use App\Repository\ReserveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReserveRepository::class)]
class Reserve
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reserves')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'reserves')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $event = null;

    #[ORM\OneToMany(mappedBy: 'reserv', targetEntity: Clent::class, orphanRemoval: true)]
    private Collection $clents;

    public function __construct()
    {
        $this->clents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

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
            $clent->setReserv($this);
        }

        return $this;
    }

    public function removeClent(Clent $clent): self
    {
        if ($this->clents->removeElement($clent)) {
            // set the owning side to null (unless already changed)
            if ($clent->getReserv() === $this) {
                $clent->setReserv(null);
            }
        }

        return $this;
    }
}
