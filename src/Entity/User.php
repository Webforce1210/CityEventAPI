<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $pseudo;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $avatar;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    private $password;

    #[ORM\Column(type: 'integer')]
    private $stars;

    #[ORM\Column(type: 'string', length: 255)]
    private $cover;

    #[ORM\Column(type: 'string', length: 255)]
    private $region;

    #[ORM\Column(type: 'json')]
    private $hobbies = [];

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserEvent::class, orphanRemoval: true)]
    private $userEvents;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: MessageActivite::class, orphanRemoval: true)]
    private $messageActivites;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: CreditCardInfo::class)]
    private $creditCardInfos;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: MessagePrive::class, orphanRemoval: true)]
    private $messagePrives;

    #[ORM\ManyToMany(targetEntity: Discussion::class, inversedBy: 'users')]
    private $discussions;

    #[ORM\OneToOne(mappedBy: 'prop', targetEntity: Contact::class, cascade: ['persist', 'remove'])]
    private $contact;

    #[ORM\ManyToMany(targetEntity: Contact::class, mappedBy: 'contacts')]
    private $contacts;

    public function __construct()
    {
        $this->userEvents = new ArrayCollection();
        $this->messageActivites = new ArrayCollection();
        $this->creditCardInfos = new ArrayCollection();
        $this->messagePrives = new ArrayCollection();
        $this->discussions = new ArrayCollection();
        $this->contacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getStars(): ?int
    {
        return $this->stars;
    }

    public function setStars(int $stars): self
    {
        $this->stars = $stars;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getHobbies(): ?array
    {
        return $this->hobbies;
    }

    public function setHobbies(array $hobbies): self
    {
        $this->hobbies = $hobbies;

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
            $userEvent->setUser($this);
        }

        return $this;
    }

    public function removeUserEvent(UserEvent $userEvent): self
    {
        if ($this->userEvents->removeElement($userEvent)) {
            // set the owning side to null (unless already changed)
            if ($userEvent->getUser() === $this) {
                $userEvent->setUser(null);
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
            $messageActivite->setUser($this);
        }

        return $this;
    }

    public function removeMessageActivite(MessageActivite $messageActivite): self
    {
        if ($this->messageActivites->removeElement($messageActivite)) {
            // set the owning side to null (unless already changed)
            if ($messageActivite->getUser() === $this) {
                $messageActivite->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CreditCardInfo>
     */
    public function getCreditCardInfos(): Collection
    {
        return $this->creditCardInfos;
    }

    public function addCreditCardInfo(CreditCardInfo $creditCardInfo): self
    {
        if (!$this->creditCardInfos->contains($creditCardInfo)) {
            $this->creditCardInfos[] = $creditCardInfo;
            $creditCardInfo->setUser($this);
        }

        return $this;
    }

    public function removeCreditCardInfo(CreditCardInfo $creditCardInfo): self
    {
        if ($this->creditCardInfos->removeElement($creditCardInfo)) {
            // set the owning side to null (unless already changed)
            if ($creditCardInfo->getUser() === $this) {
                $creditCardInfo->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MessagePrive>
     */
    public function getMessagePrives(): Collection
    {
        return $this->messagePrives;
    }

    public function addMessagePrife(MessagePrive $messagePrife): self
    {
        if (!$this->messagePrives->contains($messagePrife)) {
            $this->messagePrives[] = $messagePrife;
            $messagePrife->setUser($this);
        }

        return $this;
    }

    public function removeMessagePrife(MessagePrive $messagePrife): self
    {
        if ($this->messagePrives->removeElement($messagePrife)) {
            // set the owning side to null (unless already changed)
            if ($messagePrife->getUser() === $this) {
                $messagePrife->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Discussion>
     */
    public function getDiscussions(): Collection
    {
        return $this->discussions;
    }

    public function addDiscussion(Discussion $discussion): self
    {
        if (!$this->discussions->contains($discussion)) {
            $this->discussions[] = $discussion;
        }

        return $this;
    }

    public function removeDiscussion(Discussion $discussion): self
    {
        $this->discussions->removeElement($discussion);

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(Contact $contact): self
    {
        // set the owning side of the relation if necessary
        if ($contact->getProp() !== $this) {
            $contact->setProp($this);
        }

        $this->contact = $contact;

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->addContact($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            $contact->removeContact($this);
        }

        return $this;
    }
}
