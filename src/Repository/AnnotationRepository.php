<?php

namespace App\Repository;

use App\Entity\Annotation;
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

    public function list($onlyOld)
    {
        $entityManager = $this->getEntityManager();
        $sql = 'SELECT a
            FROM App\Entity\Annotation a
            WHERE a.deletedAt IS NULL';

        if ($onlyOld) {
            $date = new \DateTime();
            date_modify($date,'-1 week');

            $sql .= "AND a.createdAt <= '" . $date->format("Y-m-d H:i:s") . "'";
        }

        $query = $entityManager->createQuery($sql);

        return $query->getResult();
    }

    public function create($params, $user, $categories): Annotation
    {
        $annotation = new Annotation();

        foreach ($categories as $item) {
            $annotation->addCategory($item);
        }

        $annotation->setUsuario($user);
        $annotation->setNota($params['nota']);
        $annotation->setCreatedAt(new \DateTime());

        $entityManager = $this->getEntityManager();
        $entityManager->persist($annotation);
        $entityManager->flush();

        return $annotation;
    }

    public function update($id, $params, $user, $categories): Annotation
    {
        $entityManager = $this->getEntityManager();
        $annotation = $this->find($id);

        if ($user) {
            $annotation->setUsuario($user);
        }

        if ($categories) {
            $currentCategories = $annotation->getCategories();

            foreach ($currentCategories as $item) {
                $annotation->removeCategory($item);
            }

            foreach ($categories as $item) {
                $annotation->addCategory($item);
            }
        }

        if(isset($params['nota'])) {
            $annotation->setNota($params['nota']);
        }
        
        $annotation->setUpdatedAt(new \DateTime());
        $entityManager->flush();

        return $annotation;
    }

    public function delete($id, $soft): void
    {
        $entityManager = $this->getEntityManager();
        $user = $this->find($id);

        if ($soft) {
            $user->setDeletedAt(new \DateTime());
        } else {
            $entityManager->remove($user);
        }
        
        $entityManager->flush();
    }

}
