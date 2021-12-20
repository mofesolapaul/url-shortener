<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\UrlLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UrlLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method UrlLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method UrlLog[]    findAll()
 * @method UrlLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UrlLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UrlLog::class);
    }
}
