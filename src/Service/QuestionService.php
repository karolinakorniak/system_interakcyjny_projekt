<?php

namespace App\Service;

use App\Entity\Answer;
use App\Entity\Question;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class QuestionService.
 */
class QuestionService implements QuestionServiceInterface
{
    /**
     * Question repository.
     */
    private QuestionRepository $questionRepository;

    /**
     * Answer repository.
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
     * @param PaginatorInterface $paginator          Paginator
     */
    public function __construct(
        QuestionRepository $questionRepository,
        AnswerRepository $answerRepository,
        PaginatorInterface $paginator
    ) {
        $this->questionRepository = $questionRepository;
        $this->answerRepository = $answerRepository;
        $this->paginator = $paginator;
    }

    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->questionRepository->queryAll(),
            $page,
            QuestionRepository::PAGINATOR_ITEMS_PER_PAGE,
            [
                'defaultSortFieldName' => 'question.created_date',
                'defaultSortDirection' => 'desc',
            ]
        );
    }

    public function getPaginatedListByCategory(int $page, string $categorySlug): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->questionRepository->queryByCategorySlug($categorySlug),
            $page,
            QuestionRepository::PAGINATOR_ITEMS_PER_PAGE,
            [
                'defaultSortFieldName' => 'question.created_date',
                'defaultSortDirection' => 'desc',
            ]
        );
    }

    public function saveAnswer(Answer $answer, Question $question): void
    {
        $answer->setQuestion($question);
        $answer->setIsDeleted(false);
        $this->answerRepository->save($answer);
    }

    public function saveQuestion(Question $question): void
    {
        $this->questionRepository->save($question);
    }

    public function deleteQuestion(Question $question): void
    {
        $this->questionRepository->remove($question);
    }

    public function markAnswerAsDeleted(Answer $answer): void
    {
        $answer->setIsDeleted(true);
        $this->answerRepository->save($answer);
    }

    public function markAnswerAsBest(Question $question, int $id): void
    {
        $answer = $this->answerRepository->find($id);
        $question->setBestAnswer($answer);
        $this->questionRepository->save($question);
    }
}
