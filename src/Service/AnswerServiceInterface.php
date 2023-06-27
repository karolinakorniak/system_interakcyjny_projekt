<?php

namespace App\Service;

use App\Entity\Category;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface AnswerServiceInterface
 */
interface AnswerServiceInterface
{
    /**
     * Get paginated list of answers to a question given by id.
     *
     * @param int $id Question id
     * @param int $page Page number
     *
     * @return PaginationInterface Pagination
     */
    public function getPaginatedListForQuestion(int $id, int $page): PaginationInterface;
}