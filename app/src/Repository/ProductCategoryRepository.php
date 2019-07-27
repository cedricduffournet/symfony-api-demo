<?php

namespace App\Repository;

use App\Entity\ProductCategory;
use Doctrine\ORM\EntityManagerInterface;

/**
 * ProductCategoryRepository.
 */
class ProductCategoryRepository implements ProductCategoryRepositoryInterface
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
        $this->objectRepository = $this->entityManager->getRepository(ProductCategory::class);
    }

    public function find(int $id): ProductCategory
    {
        return $this->objectRepository->find($id);
    }

    public function findAll(): array
    {
        return $this->objectRepository->findAll();
    }

    public function remove(ProductCategory $productCategory): void
    {
        $this->entityManager->remove($productCategory);
        $this->entityManager->flush();
    }

    public function save(ProductCategory $ProductCategory): void
    {
        $this->entityManager->persist($ProductCategory);
        $this->entityManager->flush();
    }
}
