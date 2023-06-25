<?php

namespace App\Service;

use App\Entity\Category;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface CategoryServiceInterface
 */
interface CategoryServiceInterface
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
     * Save category.
     *
     * @param Category $category Entity to save
     */
    public function saveCategory(Category $category): void;

    /**
     * Delete category.
     *
     * @param Category $category
     * @return void
     */
    public function deleteCategory(Category $category): void;

    /**
     * Find by name.
     * @param string $name Name to search for
     * @return Category|null Category entity
     */
    public function findOneByName(string $name): ?Category;
}