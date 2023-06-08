<?php

namespace App\Service;

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
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param QuestionRepository $questionRepository Question repository
     * @param PaginatorInterface $paginator Paginator
     */
    public function __construct(QuestionRepository $questionRepository, PaginatorInterface $paginator)
    {
        $this->questionRepository = $questionRepository;
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
}