<?php

namespace App\Entity;

use App\Repository\CreditCardInfoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreditCardInfoRepository::class)]
class CreditCardInfo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $num_carte;

    #[ORM\Column(type: 'string', length: 7)]
    private $date_expi;

    #[ORM\Column(type: 'integer')]
    private $cvc;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom_prenom;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'creditCardInfos')]
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCarte(): ?string
    {
        return $this->num_carte;
    }

    public function setNumCarte(string $num_carte): self
    {
        $this->num_carte = $num_carte;

        return $this;
    }

    public function getDateExpi(): ?\DateTimeInterface
    {
        return $this->date_expi;
    }

    public function setDateExpi(\DateTimeInterface $date_expi): self
    {
        $this->date_expi = $date_expi;

        return $this;
    }

    public function getCvc(): ?int
    {
        return $this->cvc;
    }

    public function setCvc(int $cvc): self
    {
        $this->cvc = $cvc;

        return $this;
    }

    public function getNomPrenom(): ?string
    {
        return $this->nom_prenom;
    }

    public function setNomPrenom(string $nom_prenom): self
    {
        $this->nom_prenom = $nom_prenom;

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

    public function jsonSerialize()
    {
        return (object) get_object_vars($this);
    }
}
