<?php

namespace App\Entity;

use App\Repository\ServiceTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceTypeRepository::class)]
class ServiceType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'service_type', targetEntity: Service::class)]
    private Collection $services_of_type;

    public function __construct()
    {
        $this->services = new ArrayCollection();
        $this->services_of_type = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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
    public function getServicesOfType(): Collection
    {
        return $this->services_of_type;
    }

    public function addServicesOfType(Service $servicesOfType): static
    {
        if (!$this->services_of_type->contains($servicesOfType)) {
            $this->services_of_type->add($servicesOfType);
            $servicesOfType->setServiceType($this);
        }

        return $this;
    }

    public function removeServicesOfType(Service $servicesOfType): static
    {
        if ($this->services_of_type->removeElement($servicesOfType)) {
            // set the owning side to null (unless already changed)
            if ($servicesOfType->getServiceType() === $this) {
                $servicesOfType->setServiceType(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->type;
    }
    
}
