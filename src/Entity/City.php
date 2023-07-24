<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CityRepository::class)]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\Column(length: 255)]
    private ?string $city_zip_code = null;


    #[ORM\OneToMany(mappedBy: 'city', targetEntity: Service::class)]
    private Collection $services;

    #[ORM\OneToMany(mappedBy: 'city', targetEntity: UserInformation::class)]
    private Collection $userInformation;

    #[ORM\ManyToOne(inversedBy: 'cities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?County $county = null;

    public function __construct()
    {
        $this->services = new ArrayCollection();
        $this->userInformation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

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

    public function getCityZipCode(): ?string
    {
        return $this->city_zip_code;
    }

    public function setCityZipCode(string $city_zip_code): static
    {
        $this->city_zip_code = $city_zip_code;

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
            $service->setCity($this);
        }

        return $this;
    }

    public function removeService(Service $service): static
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getCity() === $this) {
                $service->setCity(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->city;
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
            $userInformation->setCity($this);
        }

        return $this;
    }

    public function removeUserInformation(UserInformation $userInformation): static
    {
        if ($this->userInformation->removeElement($userInformation)) {
            // set the owning side to null (unless already changed)
            if ($userInformation->getCity() === $this) {
                $userInformation->setCity(null);
            }
        }

        return $this;
    }

    public function getCounty(): ?County
    {
        return $this->county;
    }

    public function setCounty(?County $county): static
    {
        $this->county = $county;

        return $this;
    }
}
