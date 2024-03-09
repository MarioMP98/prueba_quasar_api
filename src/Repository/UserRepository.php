<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function list()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT u
                FROM App\Entity\User u
                WHERE u.deletedAt IS NULL'
        );

        return $query->getResult();
    }

    public function create($params)
    {
        $user = new User();

        $user->setNombre($params['nombre']);
        $user->setEmail($params['email']);
        $user->setPassword($params['password']);
        $user->setCreatedAt(new \DateTime());

        $entityManager = $this->getEntityManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $user;
    }

    public function update($id, $params): User
    {
        $entityManager = $this->getEntityManager();
        $user = $this->find($id);

        if(isset($params['nombre'])) {
            $user->setNombre($params['nombre']);
        }

        if(isset($params['email'])) {
            $user->setEmail($params['email']);
        }

        if(isset($params['password'])) {
            $user->setPassword($params['password']);
        }
        
        $user->setUpdatedAt(new \DateTime());
        $entityManager->flush();

        return $user;
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
