<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Lead;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Entity\News as NewsORM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NewsORM>
 */
class DbNewsRepository extends ServiceEntityRepository implements NewsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsORM::class);
    }

    //    /**
    //     * @return News[] Returns an array of News objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('n.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?News
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findById(int $id): ?News
    {
        // TODO: Implement findById() method.
    }

    public function findByIds(array $ids): iterable
    {
        // TODO: Implement findByIds() method.
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function save(News $news): void
    {
        $entityManager = $this->getEntityManager();
        $dbRecord = new NewsORM();
        $dbRecord->setTitle($news->getTitle()->getValue());
        $dbRecord->setUrl($news->getUrl()->getValue());
        $dbRecord->setCreatedAt($news->getCreatedAt());


        $entityManager->persist($dbRecord);
        $entityManager->flush();
        $reflectionProperty = new \ReflectionProperty(News::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($news, $dbRecord->getId());
    }
}
