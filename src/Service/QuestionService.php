<?php

namespace App\Service;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\User;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class QuestionService implements QuestionServiceInterface
{
    /**
     * Question repository.
     */
    private QuestionRepository $questionRepository;

    /**
     * Answer repository
     */
    private AnswerRepository $answerRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param QuestionRepository $questionRepository Question repository
     * @param PaginatorInterface $paginator Paginator
     */
    public function __construct(QuestionRepository $questionRepository,
                                AnswerRepository $answerRepository,
                                PaginatorInterface $paginator)
    {
        $this->questionRepository = $questionRepository;
        $this->answerRepository = $answerRepository;
        $this->paginator = $paginator;
    }


    /**
     * @inheritDoc
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->questionRepository->queryAll(),
            $page,
            QuestionRepository::PAGINATOR_ITEMS_PER_PAGE,
        );
    }

    /**
     * @inheritDoc
     */
    public function getPaginatedListByCategory(int $page, string $categorySlug): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->questionRepository->queryByCategorySlug($categorySlug),
            $page,
            QuestionRepository::PAGINATOR_ITEMS_PER_PAGE,
        );
    }

    /**
     * @inheritDoc
     */
    public function saveAnswer(Answer $answer, Question $question): void
    {
        $answer->setQuestion($question);
        $answer->setIsDeleted(false);
        $this->answerRepository->save($answer);
    }

    /**
     * @inheritDoc
     */
    public function saveQuestion(Question $question): void
    {
        $this->questionRepository->save($question);
    }

    /**
     * @inheritDoc
     */
    public function deleteQuestion(Question $question): void
    {
        $this->questionRepository->remove($question);
    }
}