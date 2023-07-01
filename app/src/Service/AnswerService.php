<?php
/**
 * Answer service.
 */

namespace App\Service;

use App\Repository\AnswerRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class AnswerService.
 */
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

    /**
     * Get paginated answers to a question.
     *
     * @param int $id   Question id
     * @param int $page Current page
     *
     * @return PaginationInterface Pagination
     */
    public function getPaginatedListForQuestion(int $id, int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->answerRepository->findByQuestionId($id),
            $page,
            AnswerRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }
}
