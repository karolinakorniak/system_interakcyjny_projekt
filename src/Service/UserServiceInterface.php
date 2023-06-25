<?php

namespace App\Service;

use App\Entity\User;

/**
 * Interface UserServiceInterface
 */
interface UserServiceInterface
{
    /**
     * Save user.
     *
     * @param User $user User entity
     */
    public function saveUser(User $user): void;

    /**
     * Update user's password
     *
     * @param User $user User entity
     * @param string $newPassword New password
     */
    public function updatePassword(User $user, string $newPassword): void;

}