<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use function Sodium\add;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    private $plainPassword;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column]
    private ?int $role = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Service::class)]
    private Collection $services;

    #[ORM\OneToMany(mappedBy: 'updater', targetEntity: Service::class)]
    private Collection $services_updated_by_user;

    #[ORM\OneToMany(mappedBy: 'rater', targetEntity: Rating::class)]
    private Collection $ratings;

    #[ORM\OneToMany(mappedBy: 'updater', targetEntity: Service::class)]
    private Collection $updated_services;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?UserInformation $userInformation = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserRating::class)]
    private Collection $userRatings;
    private RoleRepository $roleRepository;

    public function __construct()
    {
        $this->services = new ArrayCollection();
        $this->services_created_by_user = new ArrayCollection();
        $this->services_updated_by_user = new ArrayCollection();
        $this->ratings = new ArrayCollection();
        $this->updated_services = new ArrayCollection();
        $this->userRatings = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getUserIdentifier(): ?string
    {
        return $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }
/*
    public function setPasswordFactory(string $password): static
    {
        $this->password = $password;

        return $this;
    }
*/

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getRole(): ?int
    {
        return $this->role;
    }

    public function setRole(int $role): static
    {
        $this->role = $role;

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
            $service->setOwner($this);
        }

        return $this;
    }

    public function removeService(Service $service): static
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getOwner() === $this) {
                $service->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServicesCreatedByUser(): Collection
    {
        return $this->services_created_by_user;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServicesUpdatedByUser(): Collection
    {
        return $this->services_updated_by_user;
    }

    public function addServicesUpdatedByUser(Service $servicesUpdatedByUser): static
    {
        if (!$this->services_updated_by_user->contains($servicesUpdatedByUser)) {
            $this->services_updated_by_user->add($servicesUpdatedByUser);
            $servicesUpdatedByUser->setUpdater($this);
        }

        return $this;
    }

    public function removeServicesUpdatedByUser(Service $servicesUpdatedByUser): static
    {
        if ($this->services_updated_by_user->removeElement($servicesUpdatedByUser)) {
            // set the owning side to null (unless already changed)
            if ($servicesUpdatedByUser->getUpdater() === $this) {
                $servicesUpdatedByUser->setUpdater(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rating>
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): static
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings->add($rating);
            $rating->setRater($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): static
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getRater() === $this) {
                $rating->setRater(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getUpdatedServices(): Collection
    {
        return $this->updated_services;
    }

    public function addUpdatedService(Service $updatedService): static
    {
        if (!$this->updated_services->contains($updatedService)) {
            $this->updated_services->add($updatedService);
            $updatedService->setUpdater($this);
        }

        return $this;
    }

    public function removeUpdatedService(Service $updatedService): static
    {
        if ($this->updated_services->removeElement($updatedService)) {
            // set the owning side to null (unless already changed)
            if ($updatedService->getUpdater() === $this) {
                $updatedService->setUpdater(null);
            }
        }

        return $this;
    }

    public function getUserInformation(): ?UserInformation
    {
        return $this->userInformation;
    }

    public function setUserInformation(UserInformation $userInformation): static
    {
        // set the owning side of the relation if necessary
        if ($userInformation->getUser() !== $this) {
            $userInformation->setUser($this);
        }

        $this->userInformation = $userInformation;

        return $this;
    }

    /**
     * @return Collection<int, UserRating>
     */
    public function getUserRatings(): Collection
    {
        return $this->userRatings;
    }

    public function addUserRating(UserRating $userRating): static
    {
        if (!$this->userRatings->contains($userRating)) {
            $this->userRatings->add($userRating);
            $userRating->setUser($this);
        }

        return $this;
    }

    public function removeUserRating(UserRating $userRating): static
    {
        if ($this->userRatings->removeElement($userRating)) {
            // set the owning side to null (unless already changed)
            if ($userRating->getUser() === $this) {
                $userRating->setUser(null);
            }
        }

        return $this;
    }

    public function getRoles()
    {
        //1=> admin
        //2 => editor
        //4 => user


        $array = [1 => 'ROLE_ADMIN', 2 => 'ROLE_EDITOR', 4 => 'ROLE_USER', 8 => 'ROLE_ALLOWED_TO_SWITCH']; //ovo zamjeniti s role-ovima iz baze
        $number = $this->role;
        $allUserRoles = [];

        foreach ($array as $mask => $string) {
            if ($number & $mask) {
                array_push($allUserRoles, $string) . PHP_EOL;
            }
        }

        return $allUserRoles;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function __call(string $name, array $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }


    /**
     * @return mixed
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }


}
