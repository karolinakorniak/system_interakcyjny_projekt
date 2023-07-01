<?php
/**
 * Answer entity.
 */

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Answer.
 */
#[ORM\Entity(repositoryClass: AnswerRepository::class)]
#[ORM\Table(name: 'answers')]
class Answer
{
    /**
     * Primary key.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Username.
     */
    #[ORM\Column(length: 191)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 191)]
    private ?string $username = null;

    /**
     * Email.
     */
    #[ORM\Column(length: 191)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 191)]
    private ?string $email = null;

    /**
     * Content.
     */
    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 500)]
    private ?string $content = null;

    /**
     * Created at.
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\Type(\DateTimeInterface::class)]
    #[Gedmo\Timestampable(on: 'create')]
    private ?\DateTimeInterface $date = null;

    /**
     * Is marked as deleted.
     */
    #[ORM\Column]
    private ?bool $isDeleted = null;

    /**
     * Related Question.
     */
    #[ORM\ManyToOne(fetch: 'EXTRA_LAZY', inversedBy: 'answers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $question = null;

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
     * Getter for username.
     *
     * @return string|null Username
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Setter for username.
     *
     * @param string $username Username to set
     *
     * @return $this
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Getter for email.
     *
     * @return string|null Email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Setter for email.
     *
     * @param string $email Email to set
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

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
     * Getter for created at date.
     *
     * @return \DateTimeInterface|null CreatedAt date
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * Setter for created at date.
     *
     * @param \DateTimeInterface $date Date to set
     *
     * @return $this
     */
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Getter for isDeleted.
     *
     * @return bool|null Is this Answer marked as deleted
     */
    public function isIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    /**
     * Setter for isDeleted.
     *
     * @param bool $isDeleted Whether this Answer should be marked as deleted
     *
     * @return $this
     */
    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Getter for Question.
     *
     * @return Question|null Related Question entity
     */
    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    /**
     * Setter for Question.
     *
     * @param Question|null $question Question entity
     *
     * @return $this
     */
    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }
}
