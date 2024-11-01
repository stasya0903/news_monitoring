<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;
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
     * @return void
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

    /**
     * @param array $ids
     * @return iterable
     */
    public function findByIds(iterable $ids = []): iterable
    {
        $query = $this->createQueryBuilder('news');
        if (count($ids)) {
            $query->andWhere('news.id IN (:ids)')
                ->setParameter('ids', $ids);
        }
        $items =  $query->getQuery()->getResult();
        $reflectionProperty = new \ReflectionProperty(News::class, 'id');
        $reflectionProperty->setAccessible(true);
        return array_map(function (NewsORM $dbRecord) use ($reflectionProperty) {
            $news = new News(
                new Url($dbRecord->getUrl()),
                new Title($dbRecord->getTitle()),
                $dbRecord->getCreatedAt()
            );
            $reflectionProperty->setValue($news, $dbRecord->getId());
            return $news;
        }, $items);
    }
}
