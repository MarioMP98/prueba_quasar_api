<?php

namespace App\Repository;

use App\Entity\Annotation;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Annotation>
 *
 * @method Annotation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annotation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annotation[]    findAll()
 * @method Annotation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnotationRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annotation::class);
    }


    /**
     * Recupera todas las notas
     *
     * @param boolean $onlyOld Sirve para que solo traiga las notas creadas hace más de 7 días
     * @return array
     */
    public function list($onlyOld): array
    {
        $entityManager = $this->getEntityManager();
        $sql = 'SELECT a
            FROM App\Entity\Annotation a
            WHERE a.deletedAt IS NULL';

        if ($onlyOld) {
            $date = new \DateTime();
            date_modify($date,'-1 week');

            $sql .= " AND a.createdAt <= '" . $date->format("Y-m-d H:i:s") . "'";
        }

        $query = $entityManager->createQuery($sql);

        return $query->getResult();
    }


    /**
     * Crea una nota nueva
     *
     * @param array $params Contiene los parametros a guardar
     * @param User $user El usuario a asignar a la nota
     * @param array $categories Las categorías a asignar a la nota
     * @return Annotation
     */
    public function create($params, $user, $categories): Annotation
    {
        $annotation = new Annotation();

        foreach ($categories as $item) {
            $annotation->addCategory($item);
        }

        if ($user) {
            $annotation->setUsuario($user);
        }

        if(isset($params['nota'])) {
            $annotation->setNota($params['nota']);
        }

        $annotation->setCreatedAt(new \DateTime());

        $entityManager = $this->getEntityManager();
        $entityManager->persist($annotation);
        $entityManager->flush();

        return $annotation;
    }


    /**
     * Actualiza una nota existente
     *
     * @param int $id La id de la nota a modificar
     * @param array $params Contiene los parametros a guardar
     * @param User $user El usuario a asignar a la nota
     * @param array $categories Las categorías a asignar a la nota
     * @return Annotation|null
     */
    public function update($id, $params, $user, $categories): Annotation|null
    {
        $entityManager = $this->getEntityManager();
        $annotation = $this->find($id);

        if($annotation) {

            if ($user) {
                $annotation->setUsuario($user);
            }
    
            if ($categories) {
                $this->updateCategories($categories, $annotation);
            }
    
            if(isset($params['nota'])) {
                $annotation->setNota($params['nota']);
            }
            
            $annotation->setUpdatedAt(new \DateTime());
            $entityManager->flush();
        }

        return $annotation;
    }


    /**
     * Elimina una nota existente
     *
     * @param int $id La id de la nota a eliminar
     * @param boolean $soft Determina si se realiza o no un SoftDelete
     * @return Annotation|null
     */
    public function delete($id, $soft): Annotation|null
    {
        $entityManager = $this->getEntityManager();
        $annotation = $this->find($id);

        if($annotation) {

            if ($soft) {
                $annotation->setDeletedAt(new \DateTime());
            } else {
                $entityManager->remove($annotation);
            }
            
            $entityManager->flush();
        }

        return $annotation;
    }


    /**
     * Elimina una nota existente
     *
     * @param array $categories Las categorías a asignar a la nota
     * @param Annotation $annotation El objeto de la nota a actualizar
     */
    private function updateCategories($categories, $annotation): void
    {
        $currentCategories = $annotation->getCategories();

        foreach ($currentCategories as $item) {
            $annotation->removeCategory($item);
        }

        foreach ($categories as $item) {
            $annotation->addCategory($item);
        }
    }

}
