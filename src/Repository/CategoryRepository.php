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


    /**
     * Recupera todas las categorías
     *
     * @return array
     */
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


    /**
     * Recupera las categorias correspondientes a las ids
     *
     * @param array $ids Las ids de las categorías que se quieren recuperar
     * @return array
     */
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


    /**
     * Crea una categoría nueva
     *
     * @param array $params Contiene los parametros a guardar
     * @return Category
     */
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


    /**
     * Actualiza una categoría existente
     *
     * @param int $id La id de la categoría a modificar
     * @param array $params Contiene los parametros a guardar
     * @return Category|null
     */
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


    /**
     * Elimina una categoría existente
     *
     * @param int $id La id de la categoría a eliminar
     * @param boolean $soft Determina si se realiza o no un SoftDelete
     * @return Category|null
     */
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
