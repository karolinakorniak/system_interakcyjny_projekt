<?php

namespace App\Entity;

use App\Repository\UserDataRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserDara
 */
#[ORM\Entity(repositoryClass: UserDataRepository::class)]
#[ORM\Table(name: 'user_data')]
class UserData
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
    #[ORM\Column(length: 255)]
    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $name = null;

    /**
     * Description.
     * @var string|null
     */
    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 500)]
    private ?string $description = null;

    /**
     * User.
     * @var User|null
     */
    #[ORM\OneToOne(inversedBy: 'userData', cascade: ['persist', 'remove'], fetch: "EXTRA_LAZY")]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * Getter for id.
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for User.
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Setter for User.
     * @param User $user
     * @return $this
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Getter for name.
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
     * Getter for description
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Setter for description
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
