<?php
/**
 * Question entity.
 */

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Question.
 */
#[ORM\Entity(repositoryClass: QuestionRepository::class)]
#[ORM\Table(name: 'questions')]
class Question
{
    /**
     * Primary key.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Title.
     */
    #[ORM\Column(length: 150)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 150)]
    private ?string $title = null;

    /**
     * Slug based on title.
     */
    #[ORM\Column(length: 150)]
    #[Assert\Length(min: 3, max: 150)]
    #[Gedmo\Slug(fields: ['title'])]
    private ?string $slug = null;

    /**
     * Content.
     */
    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 500)]
    private ?string $content = null;

    /**
     * Created at.
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Timestampable(on: 'create')]
    #[Assert\Type(\DateTimeInterface::class)]
    private ?\DateTimeInterface $created_date = null;

    /**
     * Last modified at.
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Timestampable(on: 'update')]
    #[Assert\Type(\DateTimeInterface::class)]
    private ?\DateTimeInterface $last_modified_date = null;

    /**
     * Categories of this question.
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'questions', fetch: 'EXTRA_LAZY')]
    private Collection $categories;

    /**
     * Answers to this question.
     */
    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Answer::class, fetch: 'EXTRA_LAZY', orphanRemoval: true)]
    private Collection $answers;

    /**
     * Best answer.
     */
    #[ORM\OneToOne(cascade: ['persist', 'remove'], fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    private ?Answer $best_answer = null;

    /**
     * Author.
     */
    #[ORM\ManyToOne(fetch: 'EXTRA_LAZY', inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->answers = new ArrayCollection();
    }

    /**
     * Getter for id.
     *
     * @return int|null Id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for title.
     *
     * @return string|null Title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setter for title.
     *
     * @param string $title Title to set
     *
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Getter for slug.
     *
     * @return string|null Slug
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Setter for slug.
     *
     * @param string $slug Slug to set
     *
     * @return $this
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Getter for content.
     *
     * @return string|null Content
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Setter for content.
     *
     * @param string $content Content to set
     *
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Getter for create at.
     *
     * @return \DateTimeInterface|null CreatedAt date
     */
    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->created_date;
    }

    /**
     * Setter for created at.
     *
     * @param \DateTimeInterface $created_date Date to set
     *
     * @return $this
     */
    public function setCreatedDate(\DateTimeInterface $created_date): self
    {
        $this->created_date = $created_date;

        return $this;
    }

    /**
     * Getter for last modified at.
     *
     * @return \DateTimeInterface|null LastModifiedAt date
     */
    public function getLastModifiedDate(): ?\DateTimeInterface
    {
        return $this->last_modified_date;
    }

    /**
     * Setter for last modified at.
     *
     * @param \DateTimeInterface $last_modified_date Date to set
     *
     * @return $this
     */
    public function setLastModifiedDate(\DateTimeInterface $last_modified_date): self
    {
        $this->last_modified_date = $last_modified_date;

        return $this;
    }

    /**
     * Getter for author.
     *
     * @return User|null Author
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * Setter for author.
     *
     * @param User|null $author Author to set
     *
     * @return $this
     */
    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Getter for categories.
     *
     * @return Collection<int, Category> Categories
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * Add category.
     *
     * @param Category $category Category entity
     *
     * @return $this
     */
    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    /**
     * Remove category.
     *
     * @param Category $category Category entity
     *
     * @return $this
     */
    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * Getter for answers.
     *
     * @return Collection<int, Answer> Answers
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    /**
     * Add answer.
     *
     * @param Answer $answer Answer entity
     *
     * @return $this
     */
    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
            $answer->setQuestion($this);
        }

        return $this;
    }

    /**
     * Remove an answer.
     *
     * @param Answer $answer Answer entity
     *
     * @return $this
     */
    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

        return $this;
    }

    /**
     * Getter for best answer.
     *
     * @return Answer|null Best answer, if it exists
     */
    public function getBestAnswer(): ?Answer
    {
        return $this->best_answer;
    }

    /**
     * Setter for best answer.
     *
     * @param Answer|null $best_answer Answer entity
     *
     * @return $this
     */
    public function setBestAnswer(?Answer $best_answer): self
    {
        $this->best_answer = $best_answer;

        return $this;
    }
}
