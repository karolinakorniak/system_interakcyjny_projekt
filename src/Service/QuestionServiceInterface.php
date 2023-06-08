<?php

namespace App\Service;

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
}