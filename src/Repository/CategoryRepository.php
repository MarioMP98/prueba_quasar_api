<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function list()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT c
                FROM App\Entity\Category c
                WHERE c.deletedAt IS NULL'
        );

        return $query->getResult();
    }

    public function findIn(array $ids)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT c
                FROM App\Entity\Category c
                WHERE c.id IN (:ids)'
        )->setParameter('ids', $ids);

        return $query->getResult();
    }

    public function create($params): Category
    {
        $user = new Category();

        $user->setNombre($params['nombre']);
        $user->setDescripcion($params['descripcion']);
        $user->setCreatedAt(new \DateTime());

        $entityManager = $this->getEntityManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $user;
    }

    public function update($id, $params): Category
    {
        $entityManager = $this->getEntityManager();
        $category = $this->find($id);

        if(isset($params['nombre'])) {
            $category->setNombre($params['nombre']);
        }

        if(isset($params['descripcion'])) {
            $category->setDescripcion($params['descripcion']);
        }
        
        $category->setUpdatedAt(new \DateTime());
        $entityManager->flush();

        return $category;
    }

    public function delete($id, $soft): void
    {
        $entityManager = $this->getEntityManager();
        $category = $this->find($id);

        if ($soft) {
            $category->setDeletedAt(new \DateTime());
        } else {
            $entityManager->remove($category);
        }
        
        $entityManager->flush();
    }

}
