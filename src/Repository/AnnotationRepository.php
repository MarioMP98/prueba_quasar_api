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

    public function list()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT a
                FROM App\Entity\Annotation a
                WHERE a.deletedAt IS NULL'
        );

        return $query->getResult();
    }

    public function create($params, $user): Annotation
    {
        $annotation = new Annotation();

        $annotation->setUsuario($user);
        $annotation->setNota($params['nota']);
        $annotation->setCreatedAt(new \DateTime());

        $entityManager = $this->getEntityManager();
        $entityManager->persist($annotation);
        $entityManager->flush();

        return $annotation;
    }

    public function update($id, $params, $user): Annotation
    {
        $entityManager = $this->getEntityManager();
        $annotation = $this->find($id);

        if ($user) {
            $annotation->setUsuario($user);
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
