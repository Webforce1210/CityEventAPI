<?php

namespace App\Entity;

use App\Repository\MessagePriveRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessagePriveRepository::class)]
class MessagePrive
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"SEQUENCE")]
    #[ORM\SequenceGenerator(sequenceName:"id", initialValue:250000)]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $message;

    #[ORM\Column(type: 'string',length:255)]
    private $date;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'messagePrives')]
    #[ORM\JoinColumn()]
    private $user;

    #[ORM\ManyToOne(targetEntity: Discussion::class, inversedBy: 'messagePrives')]
    #[ORM\JoinColumn()]
    private $discussion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

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

    public function getDiscussion(): ?Discussion
    {
        return $this->discussion;
    }

    public function setDiscussion(?Discussion $discussion): self
    {
        $this->discussion = $discussion;

        return $this;
    }

    public function jsonSerialize()
    {
        return (object) get_object_vars($this);
    }
}
