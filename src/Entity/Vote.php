<?php

namespace App\Entity;

use App\Repository\VoteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VoteRepository::class)]
class Vote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message: "Veuillez entrer votre note.")]
    #[Assert\Type('integer', message: "Veuillez entrer un chiffre entier entre 1 et 5.")]
    #[Assert\Length(min: 1, max: 5, minMessage: "Veuillez entrer un chiffre entier entre 1 et 5.", maxMessage: "Veuillez entrer un chiffre entier entre 1 et 5.")]
    private $rating;

    #[ORM\ManyToOne(targetEntity:'App\Entity\Post', inversedBy:'vote')]
    private $post;

    #[ORM\ManyToOne(targetEntity:'App\Entity\Subscriber', inversedBy:'vote')]
    private $subscriber;
    
    public function __toString(): string
    {
    return $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function getSubscriber()
    {
        return $this->subscriber;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function setSubscriber(?Subscriber $subscriber): self
    {
        $this->subscriber = $subscriber;

        return $this;
    }
}
