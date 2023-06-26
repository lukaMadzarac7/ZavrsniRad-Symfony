<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="owner_id", referencedColumnName="id")
     */
    #[ORM\Column]
    private ?int $owner_id = null;
    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="creator_id", referencedColumnName="id")
     */
    #[ORM\Column]
    private ?int $creator_id = null;
    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="updater_id", referencedColumnName="id")
     */
    #[ORM\Column]
    private ?int $updater_id = null;
    /**
     * @ManyToOne(targetEntity="ServiceStatus")
     * @JoinColumn(name="service_status_id", referencedColumnName="id")
     */
    #[ORM\Column]
    private ?int $service_status_id = null;
    /**
     * @ManyToOne(targetEntity="ServiceType")
     * @JoinColumn(name="service_type_id", referencedColumnName="id")
     */
    #[ORM\Column]
    private ?int $service_type_id = null;
    /**
     * @ManyToOne(targetEntity="ServiceField")
     * @JoinColumn(name="service_field_id", referencedColumnName="id")
     */
    #[ORM\Column]
    private ?int $service_field_id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $adress = null;
    /**
     * @ManyToOne(targetEntity="City")
     * @JoinColumn(name="city_id", referencedColumnName="id")
     */
    #[ORM\Column]
    private ?int $city_id = null;
    /**
     * @ManyToOne(targetEntity="County")
     * @JoinColumn(name="county_id", referencedColumnName="id")
     */
    #[ORM\Column]
    private ?int $county_id = null;
    /**
     * @ManyToOne(targetEntity="Country")
     * @JoinColumn(name="country_id", referencedColumnName="id")
     */
    #[ORM\Column]
    private ?int $country_id = null;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwnerId(): ?int
    {
        return $this->owner_id;
    }

    public function setOwnerId(int $owner_id): static
    {
        $this->owner_id = $owner_id;

        return $this;
    }

    public function getCreatorId(): ?int
    {
        return $this->creator_id;
    }

    public function setCreatorId(int $creator_id): static
    {
        $this->creator_id = $creator_id;

        return $this;
    }

    public function getUpdaterId(): ?int
    {
        return $this->updater_id;
    }

    public function setUpdaterId(int $updater_id): static
    {
        $this->updater_id = $updater_id;

        return $this;
    }

    public function getServiceStatusId(): ?int
    {
        return $this->service_status_id;
    }

    public function setServiceStatusId(int $service_status_id): static
    {
        $this->service_status_id = $service_status_id;

        return $this;
    }

    public function getServiceTypeId(): ?int
    {
        return $this->service_type_id;
    }

    public function setServiceTypeId(int $service_type_id): static
    {
        $this->service_type_id = $service_type_id;

        return $this;
    }

    public function getServiceFieldId(): ?int
    {
        return $this->service_field_id;
    }

    public function setServiceFieldId(int $service_field_id): static
    {
        $this->service_field_id = $service_field_id;

        return $this;
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

    public function getCityId(): ?int
    {
        return $this->city_id;
    }

    public function setCityId(int $city_id): static
    {
        $this->city_id = $city_id;

        return $this;
    }

    public function getCountyId(): ?int
    {
        return $this->county_id;
    }

    public function setCountyId(int $county_id): static
    {
        $this->county_id = $county_id;

        return $this;
    }

    public function getCountryId(): ?int
    {
        return $this->country_id;
    }

    public function setCountryId(int $country_id): static
    {
        $this->country_id = $country_id;

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
}
