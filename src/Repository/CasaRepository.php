<?php

namespace App\Repository;

use App\Entity\Casa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method Casa|null find($id, $lockMode = null, $lockVersion = null)
 * @method Casa|null findOneBy(array $criteria, array $orderBy = null)
 * @method Casa[]    findAll()
 * @method Casa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CasaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Casa::class);
    }

    public function paginate($dql, $page = 1, $limit = 3)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1)) // Offset
            ->setMaxResults($limit); // Limit

        return $paginator;
    }

    public function getAllCasas($currentPage = 1, $limit = 3)
    {
        // Create our query
        $query = $this->createQueryBuilder('p')
            ->getQuery();


        $paginator = $this->paginate($query, $currentPage, $limit);

        return array('paginator' => $paginator, 'query' => $query);
    }

    public function getCasasFiltrado($currentPage = 1, $limit = 3, $request)
    {
        // Create our query
        $query = $this->createQueryBuilder('p');

        if ($request->get('casa')['tipo_venta']) $query->andWhere('p.tipo_venta = :tipo_venta')->setParameter('tipo_venta', $request->get('casa')['tipo_venta']);
        if ($request->get('casa')['tipo_casa']) $query->andWhere('p.tipo_casa = :tipo_casa')->setParameter('tipo_casa', $request->get('casa')['tipo_casa']);
        if ($request->get('casa')['id_ciu']) $query->andWhere('p.id_ciu = :id_ciu')->setParameter('id_ciu', $request->get('casa')['id_ciu']);

        if ($request->get('m2min')) $query->andWhere('p.m2 > :m2min')->setParameter('m2min', $request->get('m2min'));
        if ($request->get('m2max')) $query->andWhere('p.m2 < :m2max')->setParameter('m2max', $request->get('m2max'));
        if ($request->get('preciomin')) $query->andWhere('p.precio > :preciomin')->setParameter('preciomin', $request->get('preciomin'));
        if ($request->get('preciomax')) $query->andWhere('p.precio < :preciomax')->setParameter('preciomax', $request->get('preciomax'));
        if ($request->get('h') != null) {

        $habit = $request->get('h');
        if (count($habit) > 1) {

            $or = $query->expr()->orX();

            foreach ($habit as $hab) {
                if ($hab && $hab != '4') {
                    $or->add($query->expr()->eq('p.habitaciones', ':hab'));
                    $query->setParameter('hab', $hab);
                } elseif ($hab == '4') {
                    $or->add($query->expr()->lt(':hab', 'p.habitaciones'));
                    $query->setParameter('hab', $hab - 1);
                }
            }
            $query->andWhere($or);
        }
    }
    if ($request->get('b') != null) {

        $banos = $request->get('b');
        if (count($banos) > 1) {
            $or = $query->expr()->orX();

            foreach ($banos as $ban) {
                if ($ban && $ban != '4') {
                    $or->add($query->expr()->eq('p.banos', ':ban'));
                    $query->setParameter('ban', $ban);
                } elseif ($ban == '4') {
                    $or->add($query->expr()->lt(':ban', 'p.banos'));
                    $query->setParameter('ban', $ban - 1);
                }
            }
            $query->andWhere($or);
        }
    }

        $query->getQuery();
        $paginator = $this->paginate($query, $currentPage, $limit);

        return array('paginator' => $paginator, 'query' => $query);
    }

    public function acceso($usuario)
    {
        $admin = false;
        $user = false;
        $acceso = '';

        foreach ($usuario as $u) {
            if ($u == 'ROLE_ADMIN') $admin = true;
            elseif ($u == 'ROLE_USER') $user = true;
        }

        if ($admin) $acceso = 'admin';
        elseif ($user) $acceso = 'user';
        else $acceso = 'anonymous';

        return $acceso;
    }

    // /**
    //  * @return Casa[] Returns an array of Casa objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Casa
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
