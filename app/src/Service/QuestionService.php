<?php
/**
 * Question service.
 */

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
     * @param AnswerRepository   $answerRepository   Answer repository
     * @param PaginatorInterface $paginator          Paginator
     */
    public function __construct(QuestionRepository $questionRepository, AnswerRepository $answerRepository, PaginatorInterface $paginator)
    {
        $this->questionRepository = $questionRepository;
        $this->answerRepository = $answerRepository;
        $this->paginator = $paginator;
    }

    /**
     * Get paginated list of questions.
     *
     * @param int $page Current page
     *
     * @return PaginationInterface Pagination
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->questionRepository->queryAll(),
            $page,
            QuestionRepository::PAGINATOR_ITEMS_PER_PAGE,
            [
                'defaultSortFieldName' => 'question.createdAt',
                'defaultSortDirection' => 'desc',
            ]
        );
    }

    /**
     * Get paginated list of questions in given category.
     *
     * @param int    $page         Current page
     * @param string $categorySlug category slug
     *
     * @return PaginationInterface Pagination
     */
    public function getPaginatedListByCategory(int $page, string $categorySlug): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->questionRepository->queryByCategorySlug($categorySlug),
            $page,
            QuestionRepository::PAGINATOR_ITEMS_PER_PAGE,
            [
                'defaultSortFieldName' => 'question.createdAt',
                'defaultSortDirection' => 'desc',
            ]
        );
    }

    /**
     * Save answer to a question.
     *
     * @param Answer   $answer   Answer entity
     * @param Question $question Question entity
     */
    public function saveAnswer(Answer $answer, Question $question): void
    {
        $answer->setQuestion($question);
        $answer->setIsDeleted(false);
        $this->answerRepository->save($answer);
    }

    /**
     * Save question.
     *
     * @param Question $question Question entity
     */
    public function saveQuestion(Question $question): void
    {
        $this->questionRepository->save($question);
    }

    /**
     * Delete question.
     *
     * @param Question $question Question entity
     */
    public function deleteQuestion(Question $question): void
    {
        $this->questionRepository->remove($question);
    }

    /**
     * Mark answer as deleted.
     *
     * @param Answer $answer Answer entity
     */
    public function markAnswerAsDeleted(Answer $answer): void
    {
        $answer->setIsDeleted(true);
        $this->answerRepository->save($answer);
    }

    /**
     * Mark answer as best answer to given question.
     *
     * @param Question $question Question entity
     * @param int      $id       Answer id
     */
    public function markAnswerAsBest(Question $question, int $id): void
    {
        $answer = $this->answerRepository->find($id);
        $question->setBestAnswer($answer);
        $this->questionRepository->save($question);
    }
}
