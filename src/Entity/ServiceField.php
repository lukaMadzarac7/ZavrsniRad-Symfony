<?php

namespace App\Entity;

use App\Repository\ServiceFieldRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceFieldRepository::class)]
class ServiceField
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $field = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'service_field', targetEntity: Service::class)]
    private Collection $services;

    #[ORM\OneToMany(mappedBy: 'service_field', targetEntity: Service::class)]
    private Collection $services_of_field;

    public function __construct()
    {
        $this->services = new ArrayCollection();
        $this->services_of_field = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getField(): ?string
    {
        return $this->field;
    }

    public function setField(string $field): static
    {
        $this->field = $field;

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
            $service->setServiceField($this);
        }

        return $this;
    }

    public function removeService(Service $service): static
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getServiceField() === $this) {
                $service->setServiceField(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServicesOfField(): Collection
    {
        return $this->services_of_field;
    }

    public function addServicesOfField(Service $servicesOfField): static
    {
        if (!$this->services_of_field->contains($servicesOfField)) {
            $this->services_of_field->add($servicesOfField);
            $servicesOfField->setServiceField($this);
        }

        return $this;
    }

    public function removeServicesOfField(Service $servicesOfField): static
    {
        if ($this->services_of_field->removeElement($servicesOfField)) {
            // set the owning side to null (unless already changed)
            if ($servicesOfField->getServiceField() === $this) {
                $servicesOfField->setServiceField(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->field;
    }
}
