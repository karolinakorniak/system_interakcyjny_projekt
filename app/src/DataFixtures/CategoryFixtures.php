<?php
/**
 * Category fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class CategoryFixtures.
 */
class CategoryFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Depends on UserFixtures.
     *
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }

    /**
     * Load the data.
     */
    protected function loadData(): void
    {
        $this->createMany(10, 'categories', function () {
            $category = new Category();
            $category->setName($this->faker->domainWord);
            /** @var User $author */
            $author = $this->getRandomReference('users');
            $category->setAuthor($author);

            return $category;
        });

        $this->manager->flush();
    }
}
