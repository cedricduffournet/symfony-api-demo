<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

/**
 * ProductRepository.
 */
class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ObjectRepository
     */
    private $objectRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->objectRepository = $this->entityManager->getRepository(Product::class);
    }

    public function find(int $id): Product
    {
        return $this->objectRepository->find($id);
    }

    public function findAll(): array
    {
        return $this->objectRepository->findAll();
    }

    public function remove(Product $civility): void
    {
        $this->entityManager->remove($civility);
        $this->entityManager->flush();
    }

    public function save(Product $Product): void
    {
        $this->entityManager->persist($Product);
        $this->entityManager->flush();
    }
}
