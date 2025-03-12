<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Entity\News as NewsORM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    /**
     * @param News $news
     * @return \App\Application\DTO\NewsDTO
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
