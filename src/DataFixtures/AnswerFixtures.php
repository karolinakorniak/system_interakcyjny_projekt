<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Category;
use App\Entity\Question;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AnswerFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    protected function loadData(): void
    {
        $this->createMany(200, "answers", function () {
            $answer = new Answer();
            $answer->setUsername($this->faker->userName);
            $answer->setEmail($this->faker->email);
            $answer->setContent($this->faker->paragraph);
            $answer->setIsDeleted(false);
            $answer->setDate(
                DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-50days', '-3days')
                )
            );
            /** @var Question $question */
            $question = $this->getRandomReference("questions");
            $answer->setQuestion($question);

            return $answer;
        });

        $this->manager->flush();
    }

    public function getDependencies()
    {
        return [QuestionFixtures::class];
    }
}