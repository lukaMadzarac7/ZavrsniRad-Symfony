<?php

namespace App\Entity;

use App\Repository\RatingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RatingRepository::class)]
class Rating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    #[ORM\Column]
    private ?int $rating_score = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'ratings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $rater = null;

    #[ORM\OneToMany(mappedBy: 'rating', targetEntity: UserRating::class)]
    private Collection $userRatings;

    public function __construct()
    {
        $this->userRatings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getRatingScore(): ?int
    {
        return $this->rating_score;
    }

    public function setRatingScore(int $rating_score): static
    {
        $this->rating_score = $rating_score;

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

    public function getRater(): ?User
    {
        return $this->rater;
    }

    public function setRater(?User $rater): static
    {
        $this->rater = $rater;

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
            $userRating->setRating($this);
        }

        return $this;
    }

    public function removeUserRating(UserRating $userRating): static
    {
        if ($this->userRatings->removeElement($userRating)) {
            // set the owning side to null (unless already changed)
            if ($userRating->getRating() === $this) {
                $userRating->setRating(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->text;
    }

}
