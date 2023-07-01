<?php
/**
 * Category service.
 */

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class CategoryService.
 */
class CategoryService implements CategoryServiceInterface
{
    /**
     * Category repository.
     */
    private CategoryRepository $categoryRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param CategoryRepository $categoryRepository Category Respository
     * @param PaginatorInterface $paginator          Paginator
     */
    public function __construct(CategoryRepository $categoryRepository, PaginatorInterface $paginator)
    {
        $this->categoryRepository = $categoryRepository;
        $this->paginator = $paginator;
    }

    /**
     * Get paginated list.
     *
     * @param int $page Current page
     *
     * @return PaginationInterface Pagination
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->categoryRepository->queryAll(),
            $page,
            CategoryRepository::PAGINATOR_ITEMS_PER_PAGE,
        );
    }

    /**
     * Save Category.
     *
     * @param Category $category Category entity
     */
    public function saveCategory(Category $category): void
    {
        $this->categoryRepository->save($category);
    }

    /**
     * Delete Category.
     *
     * @param Category $category Category entity
     */
    public function deleteCategory(Category $category): void
    {
        $this->categoryRepository->remove($category);
    }

    /**
     * Find category by name.
     *
     * @param string $name Name
     *
     * @return Category|null Category entity
     */
    public function findOneByName(string $name): ?Category
    {
        return $this->categoryRepository->findOneByName($name);
    }
}
