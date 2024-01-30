<?php

namespace App\Entity;

use App\Repository\TweetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TweetRepository::class)]
class Tweet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\ManyToOne(inversedBy: 'tweets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'tweet', targetEntity: Like::class, orphanRemoval: true)]
    private Collection $likes;

    #[ORM\OneToMany(mappedBy: 'tweet', targetEntity: View::class, orphanRemoval: true)]
    private Collection $views;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
        $this->views = new ArrayCollection();
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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Like>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): static
    {
        if (!$this->likes->contains($like)) {
            $this->likes->add($like);
            $like->setTweet($this);
        }

        return $this;
    }

    public function removeLike(Like $like): static
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getTweet() === $this) {
                $like->setTweet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, View>
     */
    public function getViews(): Collection
    {
        return $this->views;
    }

    public function addView(View $view): static
    {
        if (!$this->views->contains($view)) {
            $this->views->add($view);
            $view->setTweet($this);
        }

        return $this;
    }

    public function removeView(View $view): static
    {
        if ($this->views->removeElement($view)) {
            // set the owning side to null (unless already changed)
            if ($view->getTweet() === $this) {
                $view->setTweet(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }
}
