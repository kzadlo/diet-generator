<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Model\Owner;
use App\Diet\Domain\Repository\OwnerRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class OwnerRepository implements OwnerRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Owner $owner): void
    {
        $this->entityManager->persist($owner);
        $this->entityManager->flush();
    }

    public function remove(Owner $owner): void
    {
        $this->entityManager->remove($owner);
        $this->entityManager->flush();
    }

    public function findOneByEmail(string $email): ?Owner
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('o')
            ->from(Owner::class, 'o')
            ->where('o.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
