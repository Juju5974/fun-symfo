<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Veuillez faire une proposition.")]
    private $content;

    #[ORM\ManyToOne(targetEntity:'App\Entity\Subscriber', inversedBy:'post')]
    private $subscriber;

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\Column(type: 'float', nullable: true)]
    private $rating;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $votesCount;

    #[ORM\OneToMany(targetEntity:'App\Entity\Vote', mappedBy:'post')]
    private $vote;

    public function __construct()
    {
        $this->vote = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getVotesCount(): ?int
    {
        return $this->votesCount;
    }

    public function setVotesCount(?int $votesCount): self
    {
        $this->votesCount = $votesCount;

        return $this;
    }

    public function getVoteId()
    {
        return $this->vote;
    }

    /**
     * @return Collection<int, Vote>
     */
    public function getVote(): Collection
    {
        return $this->vote;
    }

    public function addVote(Vote $vote): self
    {
        if (!$this->vote->contains($vote)) {
            $this->vote[] = $vote;
            $vote->setPost($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->vote->removeElement($vote)) {
            // set the owning side to null (unless already changed)
            if ($vote->getPost() === $this) {
                $vote->setPost(null);
            }
        }

        return $this;
    }
	/**
	 * @return mixed
	 */
	function getSubscriber() {
		return $this->subscriber;
	}
	/**
	 * @param mixed $subscriber 
	 * @return Post
	 */
	function setSubscriber($subscriber): self {
		$this->subscriber = $subscriber;
		return $this;
	}
}
