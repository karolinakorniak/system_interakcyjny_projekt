<?php
/**
 * User fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Enum\UserRole;
use App\Entity\User;
use App\Entity\UserData;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class UserFixtures.
 */
class UserFixtures extends AbstractBaseFixtures
{
    public static int $USER_COUNT = 2;

    /**
     * Password hasher.
     */
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * @param UserPasswordHasherInterface $passwordHasher Password hasher
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    /**
     * Load data.
     */
    public function loadData(): void
    {
        $this->createMany(self::$USER_COUNT, "users", function ($i) {
            $user = new User();
            $user->setEmail(sprintf('admin%d@example.com', $i));
            $user->setRoles([UserRole::ROLE_ADMIN->value]);
            $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    'user1234'
                )
            );

            $userData = new UserData();
            $userData->setName($this->faker->userName);
            $userData->setDescription($this->faker->realTextBetween(110, 220));

            $user->setUserData($userData);

            return $user;
        });

        $this->manager->flush();
    }
}