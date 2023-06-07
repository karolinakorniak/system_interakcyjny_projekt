<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Question;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class QuestionFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    protected function loadData(): void
    {
        $this->createMany(20, "questions", function () {
            $question = new Question();
            $question->setTitle($this->faker->realText(20));
            $question->setContent($this->faker->realTextBetween(150, 250));
            $question->setCreatedDate(
                DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100days', '-50days')
                )
            );
            $question->setLastModifiedDate(
                DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween("-50days", '-2days')
                )
            );
            /** @var User $author */
            $author = $this->getRandomReference("users");
            $question->setAuthor($author);
            /** @var Category[] $categories */
            $categories = $this->getRandomReferences("categories", 2);
            foreach ($categories as $category) {
                $question->addCategory($category);
            }

            return $question;
        });

        $this->manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class, CategoryFixtures::class];
    }
}