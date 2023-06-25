<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Category
 */
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: 'categories')]
#[UniqueEntity(fields: ['name'])]
class Category
{
    /**
     * Primary key.
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Name.
     * @var string|null
     */
    #[ORM\Column(length: 64)]
    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 64)]
    private ?string $name = null;

    /**
     * Slug created based on name.
     * @var string|null
     */
    #[ORM\Column(length: 64)]
    #[Gedmo\Slug(fields: ['name'])]
    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 64)]
    private ?string $slug = null;

    /**
     * Author
     * @var User|null
     */
    #[ORM\ManyToOne(fetch: "EXTRA_LAZY")]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    /**
     * Questions in this category
     * @var Collection
     */
    #[ORM\ManyToMany(targetEntity: Question::class, mappedBy: 'categories', fetch: "EXTRA_LAZY")]
    private Collection $questions;

    /**
     *  Constructor
     */
    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    /**
     * Getter for id.
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for name
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Setter for name
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Getter for slug
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Setter for slug
     * @param string $slug
     * @return $this
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Getter for author
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * Setter for author
     * @param User|null $author
     * @return $this
     */
    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Getter for Question
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    /**
     * Add a question
     * @param Question $question
     * @return $this
     */
    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->addCategory($this);
        }

        return $this;
    }

    /**
     * Remove a question
     * @param Question $question
     * @return $this
     */
    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            $question->removeCategory($this);
        }

        return $this;
    }
}
