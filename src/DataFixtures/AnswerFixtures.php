<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class AnswerFixtures.
 */
class AnswerFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     */
    protected function loadData(): void
    {
        $this->createMany(200, 'answers', function () {
            $answer = new Answer();
            $answer->setUsername($this->faker->userName);
            $answer->setEmail($this->faker->email);
            $answer->setContent($this->faker->realTextBetween(100, 180));
            $answer->setIsDeleted(false);
            $answer->setDate(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-1days', '-0days')
                )
            );
            /** @var Question $question */
            $question = $this->getRandomReference('questions');
            $answer->setQuestion($question);

            return $answer;
        });

        $this->manager->flush();
    }

    /**
     * Returns dependencies.
     *
     * @return string[]
     */
    public function getDependencies()
    {
        return [QuestionFixtures::class];
    }
}
