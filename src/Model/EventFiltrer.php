<?php

namespace App\Model;

class EventFiltrer
{
    

    private ?string $titre = null;

    


    
    private ?\DateTimeInterface $startDate = null;

    private ?\DateTimeInterface $endDate = null;
    
    private ?string $lieu = null;
 

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $date): self
    {
        $this->startDate = $date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $date): self
    {
        $this->endDate = $date;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }




    
}
