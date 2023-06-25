<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use DateTimeInterface;
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
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Username.
     * @var string|null
     */
    #[ORM\Column(length: 191)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 191)]
    private ?string $username = null;

    /**
     * Email.
     * @var string|null
     */
    #[ORM\Column(length: 191)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 191)]
    private ?string $email = null;

    /**
     * Content.
     * @var string|null
     */
    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 500)]
    private ?string $content = null;

    /**
     * Created at.
     * @var DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\Type(DateTimeInterface::class)]
    #[Gedmo\Timestampable(on: 'create')]
    private ?\DateTimeInterface $date = null;

    /**
     * Is marked as deleted.
     * @var bool|null
     */
    #[ORM\Column]
    private ?bool $is_deleted = null;

    /**
     * Related Question
     * @var Question|null
     */
    #[ORM\ManyToOne(fetch: "EXTRA_LAZY", inversedBy: 'answers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $question = null;

    /**
     * Getter for id.
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for username.
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Setter for username.
     * @param string $username
     * @return $this
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Getter for email.
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Setter for email.
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Getter for content.
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Setter for content.
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Getter for created at date.
     * @return DateTimeInterface|null
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * Setter for created at date.
     * @param DateTimeInterface $date
     * @return $this
     */
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Getter for isDeleted
     * @return bool|null
     */
    public function isIsDeleted(): ?bool
    {
        return $this->is_deleted;
    }

    /**
     * Setter for isDeleted.
     * @param bool $is_deleted
     * @return $this
     */
    public function setIsDeleted(bool $is_deleted): self
    {
        $this->is_deleted = $is_deleted;

        return $this;
    }

    /**
     * Getter for Question
     * @return Question|null
     */
    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    /**
     * Setter for Question
     * @param Question|null $question
     * @return $this
     */
    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }
}
