<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService implements UserServiceInterface
{

    /**
     * User Repository
     */
    private UserRepository $userRepository;


    /**
     * Password hasher.
     */
    private UserPasswordHasherInterface $passwordHasher;


    /**
     * Constructor
     *
     * @param UserRepository $userRepository User Repository
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @inheritDoc
     */
    public function saveUser(User $user): void
    {
        $this->userRepository->save($user);
    }

    /**
     * @inheritDoc
     */
    public function updatePassword(User $user, string $newPassword): void
    {
        $hashedPassword = $this->passwordHasher->hashPassword($user, $newPassword);
        $user->setPassword($hashedPassword);
        $this->userRepository->save($user);
    }
}