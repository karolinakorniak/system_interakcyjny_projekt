<?php

namespace App\Service;

use App\Entity\Answer;
use App\Entity\Question;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface QuestionServiceInterface.
 */
interface QuestionServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface;

    /**
     * Get paginated list of questions belonging to category.
     *
     * @param int    $page         Page number
     * @param string $categorySlug Category slug
     *
     * @return PaginationInterface Paginated list
     */
    public function getPaginatedListByCategory(int $page, string $categorySlug): PaginationInterface;

    /**
     * Save an answer to a question.
     *
     * @param Answer   $answer   Answer entity to save
     * @param Question $question Question to add answer to
     */
    public function saveAnswer(Answer $answer, Question $question): void;

    /**
     * Save a question.
     *
     * @param Question $question Entity to save
     */
    public function saveQuestion(Question $question): void;

    /**
     * Delete a question.
     */
    public function deleteQuestion(Question $question): void;

    /**
     * Mark answer as deleted.
     */
    public function markAnswerAsDeleted(Answer $answer): void;

    /**
     * Mark answer as best for given question.
     *
     * @param Question $question question entity
     * @param int      $id       id of answer to be marked as best
     */
    public function markAnswerAsBest(Question $question, int $id): void;
}
