<?php

namespace App\Service;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\User;
use Knp\Component\Pager\Pagination\PaginationInterface;

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
     * @param int $page Page number
     * @param string $categorySlug Category slug
     * @return PaginationInterface Paginated list
     */
    public function getPaginatedListByCategory(int $page, string $categorySlug): PaginationInterface;

    /**
     * Save an answer to a question.
     *
     * @param Answer $answer Answer entity to save
     * @param Question $question Question to add answer to
     */
    public function saveAnswer(Answer $answer, Question $question): void;

    /**
     * Save a question.
     *
     * @param Question $question Entity to save
     */
    public function saveQuestion(Question $question): void;
}