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


    /**
     * Recupera todos los usuarios
     *
     * @return array
     */
    public function list(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT u
                FROM App\Entity\User u
                WHERE u.deletedAt IS NULL'
        );

        return $query->getResult();
    }


    /**
     * Crea un usuario nuevo
     *
     * @param array $params Contiene los parametros a guardar
     * @return User
     */
    public function create($params): User
    {
        $user = new User();

        if(isset($params['nombre'])) {
            $user->setNombre($params['nombre']);
        }

        if(isset($params['email'])) {
            $user->setEmail($params['email']);
        }

        if(isset($params['password'])) {
            $user->setPassword($params['password']);
        }

        $user->setCreatedAt(new \DateTime());

        $entityManager = $this->getEntityManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $user;
    }


    /**
     * Actualiza un usuario existente
     *
     * @param int $id La id del usuario a modificar
     * @param array $params Contiene los parametros a guardar
     * @return User|null
     */
    public function update($id, $params): User|null
    {
        $entityManager = $this->getEntityManager();
        $user = $this->find($id);

        if ($user) {

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
        }

        return $user;
    }


    /**
     * Elimina un usuario existente
     *
     * @param int $id La id del usuario a eliminar
     * @param boolean $soft Determina si se realiza o no un SoftDelete
     * @return User|null
     */
    public function delete($id, $soft): User|null
    {
        $entityManager = $this->getEntityManager();
        $user = $this->find($id);

        if ($user) {

            if ($soft) {
                $user->setDeletedAt(new \DateTime());
            } else {
                $entityManager->remove($user);
            }
            
            $entityManager->flush();
        }

        return $user;
    }
}
