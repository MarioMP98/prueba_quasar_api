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


    public function list(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT c
                FROM App\Entity\Category c
                WHERE c.deletedAt IS NULL'
        );

        return $query->getResult();
    }


    public function findIn(array $ids): array
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
        $category = new Category();

        if(isset($params['nombre'])) {
            $category->setNombre($params['nombre']);
        }

        if(isset($params['descripcion'])) {
            $category->setDescripcion($params['descripcion']);
        }

        $category->setCreatedAt(new \DateTime());

        $entityManager = $this->getEntityManager();
        $entityManager->persist($category);
        $entityManager->flush();

        return $category;
    }


    public function update($id, $params): Category|null
    {
        $entityManager = $this->getEntityManager();
        $category = $this->find($id);

        if ($category) {
            
            if(isset($params['nombre'])) {
                $category->setNombre($params['nombre']);
            }
    
            if(isset($params['descripcion'])) {
                $category->setDescripcion($params['descripcion']);
            }
            
            $category->setUpdatedAt(new \DateTime());
            $entityManager->flush();
        }

        return $category;
    }


    public function delete($id, $soft): Category|null
    {
        $entityManager = $this->getEntityManager();
        $category = $this->find($id);

        if ($category) {

            if ($soft) {
                $category->setDeletedAt(new \DateTime());
            } else {
                $entityManager->remove($category);
            }

            $entityManager->flush();
        }
        
        return $category;
    }

}
