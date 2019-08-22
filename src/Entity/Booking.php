<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 */
class Booking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan("today")
     */
    private $jour_de_visite;

    /**
     * @ORM\Column(type="boolean")
     */
    private $type_de_billet;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $e_mail;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Visitor", mappedBy="booking")
     */
    private $visitors;

    public function __construct()
    {
        $this->visitors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJourDeVisite(): ?\DateTimeInterface
    {
        return $this->jour_de_visite;
    }

    public function setJourDeVisite(\DateTimeInterface $jour_de_visite): self
    {
        $this->jour_de_visite = $jour_de_visite;

        return $this;
    }

    public function getTypeDeBillet(): ?bool
    {
        return $this->type_de_billet;
    }

    public function setTypeDeBillet(bool $type_de_billet): self
    {
        $this->type_de_billet = $type_de_billet;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getEMail(): ?string
    {
        return $this->e_mail;
    }

    public function setEMail(string $e_mail): self
    {
        $this->e_mail = $e_mail;

        return $this;
    }

    /**
     * @return Collection|Visitor[]
     */
    public function getVisitors(): Collection
    {
        return $this->visitors;
    }

    public function addVisitor(Visitor $visitor): self
    {
        if (!$this->visitors->contains($visitor)) {
            $this->visitors[] = $visitor;
            $visitor->setBooking($this);
        }

        return $this;
    }

    public function removeVisitor(Visitor $visitor): self
    {
        if ($this->visitors->contains($visitor)) {
            $this->visitors->removeElement($visitor);
            // set the owning side to null (unless already changed)
            if ($visitor->getBooking() === $this) {
                $visitor->setBooking(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return (string) $this->getId();
    }
}
