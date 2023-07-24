<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: Service::class)]
    private Collection $services;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: UserInformation::class)]
    private Collection $userInformation;

    public function __construct()
    {
        $this->services = new ArrayCollection();
        $this->userInformation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): static
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setCountry($this);
        }

        return $this;
    }

    public function removeService(Service $service): static
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getCountry() === $this) {
                $service->setCountry(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->country;
    }

    /**
     * @return Collection<int, UserInformation>
     */
    public function getUserInformation(): Collection
    {
        return $this->userInformation;
    }

    public function addUserInformation(UserInformation $userInformation): static
    {
        if (!$this->userInformation->contains($userInformation)) {
            $this->userInformation->add($userInformation);
            $userInformation->setCountry($this);
        }

        return $this;
    }

    public function removeUserInformation(UserInformation $userInformation): static
    {
        if ($this->userInformation->removeElement($userInformation)) {
            // set the owning side to null (unless already changed)
            if ($userInformation->getCountry() === $this) {
                $userInformation->setCountry(null);
            }
        }

        return $this;
    }
}
