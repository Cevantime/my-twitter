<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 30)]
    private ?string $username = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Tweet::class, orphanRemoval: true)]
    private Collection $tweets;

    #[ORM\OneToMany(mappedBy: 'user1', targetEntity: Friendship::class, orphanRemoval: true)]
    private Collection $friendships1;

    #[ORM\OneToMany(mappedBy: 'user2', targetEntity: Friendship::class, orphanRemoval: true)]
    private Collection $friendships2;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Like::class, orphanRemoval: true)]
    private Collection $likes;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: View::class)]
    private Collection $views;

    public function __construct()
    {
        $this->tweets = new ArrayCollection();
        $this->friendships1 = new ArrayCollection();
        $this->friendships2 = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->views = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
     * @return Collection<int, Tweet>
     */
    public function getTweets(): Collection
    {
        return $this->tweets;
    }

    public function addTweet(Tweet $tweet): static
    {
        if (!$this->tweets->contains($tweet)) {
            $this->tweets->add($tweet);
            $tweet->setUser($this);
        }

        return $this;
    }

    public function removeTweet(Tweet $tweet): static
    {
        if ($this->tweets->removeElement($tweet)) {
            // set the owning side to null (unless already changed)
            if ($tweet->getUser() === $this) {
                $tweet->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Friendship>
     */
    public function getFriendships1(): Collection
    {
        return $this->friendships1;
    }

    public function addFriendship1(Friendship $friendship): static
    {
        if (!$this->friendships1->contains($friendship)) {
            $this->friendships1->add($friendship);
            $friendship->setUser1($this);
        }

        return $this;
    }

    public function removeFriendship1(Friendship $friendship): static
    {
        if ($this->friendships1->removeElement($friendship)) {
            // set the owning side to null (unless already changed)
            if ($friendship->getUser1() === $this) {
                $friendship->setUser1(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Friendship>
     */
    public function getFriendships2(): Collection
    {
        return $this->friendships2;
    }

    public function addFriendships2(Friendship $friendships2): static
    {
        if (!$this->friendships2->contains($friendships2)) {
            $this->friendships2->add($friendships2);
            $friendships2->setUser2($this);
        }

        return $this;
    }

    public function removeFriendships2(Friendship $friendships2): static
    {
        if ($this->friendships2->removeElement($friendships2)) {
            // set the owning side to null (unless already changed)
            if ($friendships2->getUser2() === $this) {
                $friendships2->setUser2(null);
            }
        }

        return $this;
    }

    public function getFriendships(): Collection
    {
        return new ArrayCollection(array_merge(
            $this->friendships1->toArray(),
            $this->friendships2->toArray()
        ));
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
            $like->setUser($this);
        }

        return $this;
    }

    public function removeLike(Like $like): static
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getUser() === $this) {
                $like->setUser(null);
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
            $view->setUser($this);
        }

        return $this;
    }

    public function removeView(View $view): static
    {
        if ($this->views->removeElement($view)) {
            // set the owning side to null (unless already changed)
            if ($view->getUser() === $this) {
                $view->setUser(null);
            }
        }

        return $this;
    }
}
