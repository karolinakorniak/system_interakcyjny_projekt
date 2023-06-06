<?php
/**
 * User fixtures.
 */

namespace App\DataFixtures;

use App\Entity\User;

/**
 * Class UserFixtures.
 */
class UserFixtures extends AbstractBaseFixtures
{
    public static int $USER_COUNT = 2;

    /**
     * Load data.
     */
    public function loadData(): void
    {
        $this->createMany(self::$USER_COUNT, "users", function () {
            $user = new User();
            $user->setEmail($this->faker->email);
            $user->setPassword(
                $this->faker->password
            );

            return $user;
        });

        $this->manager->flush();
    }
}