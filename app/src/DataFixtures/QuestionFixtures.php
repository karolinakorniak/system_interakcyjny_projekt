<?php
/**
 * Question fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Question;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class QuestionFixtures.
 */
class QuestionFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Returns dependencies.
     *
     * @return string[]
     */
    public function getDependencies()
    {
        return [UserFixtures::class, CategoryFixtures::class];
    }

    /**
     * Load data.
     */
    protected function loadData(): void
    {
        $this->createMany(20, 'questions', function () {
            $question = new Question();
            $question->setTitle($this->faker->realText(20));
            $question->setContent($this->faker->realTextBetween(150, 250));
            $question->setCreatedAt(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-7days', '-1days')
                )
            );
            /** @var User $author */
            $author = $this->getRandomReference('users');
            $question->setAuthor($author);
            /** @var Category[] $categories */
            $categories = $this->getRandomReferences('categories', 2);
            foreach ($categories as $category) {
                $question->addCategory($category);
            }

            return $question;
        });

        $this->manager->flush();
    }
}
