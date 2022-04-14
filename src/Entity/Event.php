<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'string', length: 255)]
    private $adresse;

    #[ORM\Column(type: 'integer')]
    private $budget;

    #[ORM\Column(type: 'date')]
    private $date_debut;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date_fin;

    #[ORM\Column(type: 'time')]
    private $heure_debut;

    #[ORM\Column(type: 'time', nullable: true)]
    private $heure_fin;

    #[ORM\Column(type: 'string', length: 255)]
    private $type_activite;

    #[ORM\Column(type: 'integer')]
    private $nb_participant_max;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: UserEvent::class, orphanRemoval: true)]
    private $userEvents;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: MessageActivite::class, orphanRemoval: true)]
    private $messageActivites;

    public function __construct()
    {
        $this->userEvents = new ArrayCollection();
        $this->messageActivites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getBudget(): ?int
    {
        return $this->budget;
    }

    public function setBudget(int $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(?\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heure_debut;
    }

    public function setHeureDebut(\DateTimeInterface $heure_debut): self
    {
        $this->heure_debut = $heure_debut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heure_fin;
    }

    public function setHeureFin(?\DateTimeInterface $heure_fin): self
    {
        $this->heure_fin = $heure_fin;

        return $this;
    }

    public function getTypeActivite(): ?string
    {
        return $this->type_activite;
    }

    public function setTypeActivite(string $type_activite): self
    {
        $this->type_activite = $type_activite;

        return $this;
    }

    public function getNbParticipantMax(): ?int
    {
        return $this->nb_participant_max;
    }

    public function setNbParticipantMax(int $nb_participant_max): self
    {
        $this->nb_participant_max = $nb_participant_max;

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

    /**
     * @return Collection<int, UserEvent>
     */
    public function getUserEvents(): Collection
    {
        return $this->userEvents;
    }

    public function addUserEvent(UserEvent $userEvent): self
    {
        if (!$this->userEvents->contains($userEvent)) {
            $this->userEvents[] = $userEvent;
            $userEvent->setEvent($this);
        }

        return $this;
    }

    public function removeUserEvent(UserEvent $userEvent): self
    {
        if ($this->userEvents->removeElement($userEvent)) {
            // set the owning side to null (unless already changed)
            if ($userEvent->getEvent() === $this) {
                $userEvent->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MessageActivite>
     */
    public function getMessageActivites(): Collection
    {
        return $this->messageActivites;
    }

    public function addMessageActivite(MessageActivite $messageActivite): self
    {
        if (!$this->messageActivites->contains($messageActivite)) {
            $this->messageActivites[] = $messageActivite;
            $messageActivite->setEvent($this);
        }

        return $this;
    }

    public function removeMessageActivite(MessageActivite $messageActivite): self
    {
        if ($this->messageActivites->removeElement($messageActivite)) {
            // set the owning side to null (unless already changed)
            if ($messageActivite->getEvent() === $this) {
                $messageActivite->setEvent(null);
            }
        }

        return $this;
    }

    public function jsonSerialize()
    {
        return (object) get_object_vars($this);
    }   
}
