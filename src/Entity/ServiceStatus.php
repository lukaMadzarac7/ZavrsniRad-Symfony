<?php

namespace App\Entity;

use App\Repository\ServiceStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceStatusRepository::class)]
class ServiceStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'service_status', targetEntity: Service::class)]
    private Collection $services_of_status;

    public function __construct()
    {
        $this->services_of_status = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

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
    public function getServicesOfStatus(): Collection
    {
        return $this->services_of_status;
    }

    public function addServicesOfStatus(Service $servicesOfStatus): static
    {
        if (!$this->services_of_status->contains($servicesOfStatus)) {
            $this->services_of_status->add($servicesOfStatus);
            $servicesOfStatus->setServiceStatus($this);
        }

        return $this;
    }

    public function removeServicesOfStatus(Service $servicesOfStatus): static
    {
        if ($this->services_of_status->removeElement($servicesOfStatus)) {
            // set the owning side to null (unless already changed)
            if ($servicesOfStatus->getServiceStatus() === $this) {
                $servicesOfStatus->setServiceStatus(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->status;
    }

}
