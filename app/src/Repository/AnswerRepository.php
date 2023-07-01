<?php
/**
 * Answer repository.
 */

namespace App\Repository;

use App\Entity\Answer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Answer>
 *
 * @method Answer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Answer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Answer[]    findAll()
 * @method Answer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswerRepository extends ServiceEntityRepository
{
    public const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry Manager register
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Answer::class);
    }

    /**
     * Save answer.
     *
     * @param Answer $entity Answer entity
     */
    public function save(Answer $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * Remove Answer.
     *
     * @param Answer $entity Answer entity
     */
    public function remove(Answer $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * Finds all answers for a question.
     *
     * @param int $id Question id
     *
     * @return QueryBuilder Query builder
     */
    public function findByQuestionId(int $id): QueryBuilder
    {
        return $this->createQueryBuilder('answer')
            ->join('answer.question', 'question')
            ->where('question.id = :questionId')
            ->orderBy('answer.date', 'DESC')
            ->setParameter('questionId', $id);
    }
}
