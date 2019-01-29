<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ServicesDataRepository")
 */
class ServicesData
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nameService;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mailRef;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mailSecondary;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContactData", mappedBy="service", orphanRemoval=true)
     */
    private $contactData;

    public function __construct()
    {
        $this->contactData = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameService(): ?string
    {
        return $this->nameService;
    }

    public function setNameService(string $nameService): self
    {
        $this->nameService = $nameService;

        return $this;
    }

    public function getMailRef(): ?string
    {
        return $this->mailRef;
    }

    public function setMailRef(string $mailRef): self
    {
        $this->mailRef = $mailRef;

        return $this;
    }

    public function getMailSecondary(): ?string
    {
        return $this->mailSecondary;
    }

    public function setMailSecondary(string $mailSecondary): self
    {
        $this->mailSecondary = $mailSecondary;

        return $this;
    }

    /**
     * @return Collection|ContactData[]
     */
    public function getContactData(): Collection
    {
        return $this->contactData;
    }

    public function addContactData(ContactData $contactData): self
    {
        if (!$this->contactData->contains($contactData)) {
            $this->contactData[] = $contactData;
            $contactData->setService($this);
        }

        return $this;
    }

    public function removeContactData(ContactData $contactData): self
    {
        if ($this->contactData->contains($contactData)) {
            $this->contactData->removeElement($contactData);
            // set the owning side to null (unless already changed)
            if ($contactData->getService() === $this) {
                $contactData->setService(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->nameService();
    }
}
