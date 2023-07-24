<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $adress = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $deadline = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $valid_till = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'services')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $owner = null;

    #[ORM\ManyToOne]
    private ?User $creator = null;

    #[ORM\ManyToOne(inversedBy: 'updated_services')]
    private ?User $updater = null;

    #[ORM\ManyToOne(inversedBy: 'services_of_status')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ServiceStatus $service_status = null;

    #[ORM\ManyToOne(inversedBy: 'services_of_type')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ServiceType $service_type = null;

    #[ORM\ManyToOne(inversedBy: 'services_of_field')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ServiceField $service_field = null;

    #[ORM\ManyToOne(inversedBy: 'services')]
    #[ORM\JoinColumn(nullable: false)]
    private ?City $city = null;

    #[ORM\ManyToOne(inversedBy: 'services')]
    #[ORM\JoinColumn(nullable: false)]
    private ?County $county = null;

    #[ORM\ManyToOne(inversedBy: 'services')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $country = null;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: ServiceImage::class)]
    private Collection $serviceImages;

    public function __construct()
    {
        $this->service_id = new ArrayCollection();
        $this->serviceImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }


    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(\DateTimeInterface $deadline): static
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getValidTill(): ?\DateTimeInterface
    {
        return $this->valid_till;
    }

    public function setValidTill(\DateTimeInterface $valid_till): static
    {
        $this->valid_till = $valid_till;

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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): static
    {
        $this->creator = $creator;

        return $this;
    }

    public function getUpdater(): ?User
    {
        return $this->updater;
    }

    public function setUpdater(?User $updater): static
    {
        $this->updater = $updater;

        return $this;
    }

    public function getServiceStatus(): ?ServiceStatus
    {
        return $this->service_status;
    }

    public function setServiceStatus(?ServiceStatus $service_status): static
    {
        $this->service_status = $service_status;

        return $this;
    }

    public function getServiceType(): ?ServiceType
    {
        return $this->service_type;
    }

    public function setServiceType(?ServiceType $service_type): static
    {
        $this->service_type = $service_type;

        return $this;
    }

    public function getServiceField(): ?ServiceField
    {
        return $this->service_field;
    }

    public function setServiceField(?ServiceField $service_field): static
    {
        $this->service_field = $service_field;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): static
    {
        $this->city = $city;

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

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function __toString() {
        return $this->title;
    }

    /**
     * @return Collection<int, ServiceImage>
     */
    public function getServiceImages(): Collection
    {
        return $this->serviceImages;
    }

    public function addServiceImage(ServiceImage $serviceImage): static
    {
        if (!$this->serviceImages->contains($serviceImage)) {
            $this->serviceImages->add($serviceImage);
            $serviceImage->setService($this);
        }

        return $this;
    }

    public function removeServiceImage(ServiceImage $serviceImage): static
    {
        if ($this->serviceImages->removeElement($serviceImage)) {
            // set the owning side to null (unless already changed)
            if ($serviceImage->getService() === $this) {
                $serviceImage->setService(null);
            }
        }

        return $this;
    }


}

