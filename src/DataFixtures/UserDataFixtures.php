<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserData;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserDataFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    protected function loadData(): void
    {
        $this->createMany(UserFixtures::$USER_COUNT, "userData", function (int $i) {
            $userData = new UserData();
            $userData->setName($this->faker->name);
            $userData->setDescription(
                $this->faker->paragraph
            );
            /** @var User $user */
            $user = $this->getReference("users_{$i}");
            $userData->setUser($user);

            return $userData;
        });

        $this->manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}