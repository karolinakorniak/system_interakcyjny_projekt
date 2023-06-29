<?php

namespace App\Service;

use App\Repository\AnswerRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class AnswerService implements AnswerServiceInterface
{
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
     * @param AnswerRepository   $answerRepository Answer repository
     * @param PaginatorInterface $paginator        Paginator
     */
    public function __construct(AnswerRepository $answerRepository, PaginatorInterface $paginator)
    {
        $this->answerRepository = $answerRepository;
        $this->paginator = $paginator;
    }

    public function getPaginatedListForQuestion(int $id, int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->answerRepository->findByQuestionId($id),
            $page,
            AnswerRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }
}
