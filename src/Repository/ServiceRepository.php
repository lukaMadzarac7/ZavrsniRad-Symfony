<?php

namespace App\Repository;

use App\Entity\City;
use App\Entity\County;
use App\Entity\Service;
use App\Entity\ServiceField;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;

/**
 * @extends ServiceEntityRepository<Service>
 *
 * @method Service|null find($id, $lockMode = null, $lockVersion = null)
 * @method Service|null findOneBy(array $criteria, array $orderBy = null)
 * @method Service[]    findAll()
 * @method Service[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Service::class);
    }

    public function save(Service $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Service $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Service[] Returns an array of Service objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }



    public function findOneBySomeField(): ?Array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.city = :val')
            ->setParameter('val', 'a')
            ->getQuery()
            ->getArrayResult()
        ;
    }

    public function findByCity($city): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.city = :val')
            ->setParameter('val', $city)
            ->getQuery()
            ->getResult();
    }


    /**
     * @return Service[]
     */
    //                    ->setParameter('searchTerm', '%'.$term.'%')
    public function search($term, $field, $county, $city): array
    {
        if ($term == null) {
            if ($field != null && $county != null && $city != null) {
                return $this->createQueryBuilder('s')
                    ->andWhere('s.service_field = :field')
                    ->andWhere('s.county = :county')
                    ->andWhere('s.city = :city')
                    ->setParameter('field', $field)
                    ->setParameter('county', $county)
                    ->setParameter('city', $city)
                    ->getQuery()
                    ->getResult();
            } else if ($field == null && $county != null && $city != null) {
                return $this->createQueryBuilder('s')
                    ->andWhere('s.county = :county')
                    ->andWhere('s.city = :city')
                    ->setParameter('county', $county)
                    ->setParameter('city', $city)
                    ->getQuery()
                    ->getResult();
            } else if ($field != null && $county == null && $city != null) {
                return $this->createQueryBuilder('s')
                    ->andWhere('s.service_field = :field')
                    ->andWhere('s.city = :city')
                    ->setParameter('field', $field)
                    ->setParameter('city', $city)
                    ->getQuery()
                    ->getResult();
            } else if ($field != null && $county != null && $city == null) {
                return $this->createQueryBuilder('s')
                    ->andWhere('s.service_field = :field')
                    ->andWhere('s.county = :county')
                    ->setParameter('field', $field)
                    ->setParameter('county', $county)
                    ->getQuery()
                    ->getResult();
            } else if ($field == null && $county == null && $city != null) {
                return $this->createQueryBuilder('s')
                    ->andWhere('s.city = :city')
                    ->setParameter('city', $city)
                    ->getQuery()
                    ->getResult();
            } else if ($field == null && $county != null && $city == null) {
                return $this->createQueryBuilder('s')
                    ->andWhere('s.county = :county')
                    ->setParameter('county', $county)
                    ->getQuery()
                    ->getResult();
            } else if ($field != null && $county == null && $city == null) {
                return $this->createQueryBuilder('s')
                    ->andWhere('s.service_field = :field')
                    ->setParameter('field', $field)
                    ->getQuery()
                    ->getResult();
            } else if ($field == null && $county == null && $city == null) {
                return $this->createQueryBuilder('s')
                    ->getQuery()
                    ->getResult();
            }
        } else if ($field != null && $county != null && $city != null) {
            return $this->createQueryBuilder('s')
                ->andWhere('s.title LIKE :searchTerm')
                ->orWhere('s.description LIKE :searchTerm')
                ->andWhere('s.service_field = :field')
                ->andWhere('s.county = :county')
                ->andWhere('s.city = :city')
                ->setParameter('searchTerm', '%'.$term.'%')
                ->setParameter('field', $field)
                ->setParameter('county', $county)
                ->setParameter('city', $city)
                ->getQuery()
                ->getResult();
        } else if ($field == null && $county != null && $city != null) {
            return $this->createQueryBuilder('s')
                ->andWhere('s.title LIKE :searchTerm')
                ->orWhere('s.description LIKE :searchTerm')
                ->andWhere('s.county = :county')
                ->andWhere('s.city = :city')
                ->setParameter('searchTerm', '%'.$term.'%')
                ->setParameter('county', $county)
                ->setParameter('city', $city)
                ->getQuery()
                ->getResult();
        } else if ($field != null && $county == null && $city != null) {
            return $this->createQueryBuilder('s')
                ->andWhere('s.title LIKE :searchTerm')
                ->orWhere('s.description LIKE :searchTerm')
                ->andWhere('s.service_field = :field')
                ->andWhere('s.city = :city')
                ->setParameter('searchTerm', '%'.$term.'%')
                ->setParameter('field', $field)
                ->setParameter('city', $city)
                ->getQuery()
                ->getResult();
        } else if ($field != null && $county != null && $city == null) {
            return $this->createQueryBuilder('s')
                ->andWhere('s.title LIKE :searchTerm')
                ->orWhere('s.description LIKE :searchTerm')
                ->andWhere('s.service_field = :field')
                ->andWhere('s.county = :county')
                ->setParameter('searchTerm', '%'.$term.'%')
                ->setParameter('field', $field)
                ->setParameter('county', $county)
                ->getQuery()
                ->getResult();
        } else if ($field == null && $county == null && $city != null) {
            return $this->createQueryBuilder('s')
                ->andWhere('s.title LIKE :searchTerm')
                ->orWhere('s.description LIKE :searchTerm')
                ->andWhere('s.city = :city')
                ->setParameter('searchTerm', '%'.$term.'%')
                ->setParameter('city', $city)
                ->getQuery()
                ->getResult();
        } else if ($field == null && $county != null && $city == null) {
            return $this->createQueryBuilder('s')
                ->andWhere('s.title LIKE :searchTerm')
                ->orWhere('s.description LIKE :searchTerm')
                ->andWhere('s.county = :county')
                ->setParameter('searchTerm', '%'.$term.'%')
                ->setParameter('county', $county)
                ->getQuery()
                ->getResult();
        } else if ($field != null && $county == null && $city == null) {
            return $this->createQueryBuilder('s')
                ->andWhere('s.title LIKE :searchTerm')
                ->orWhere('s.description LIKE :searchTerm')
                ->andWhere('s.service_field = :field')
                ->setParameter('searchTerm', '%'.$term.'%')
                ->setParameter('field', $field)
                ->getQuery()
                ->getResult();
        } else if ($field == null && $county == null && $city == null) {
            return $this->createQueryBuilder('s')
                ->andWhere('s.title LIKE :searchTerm')
                ->orWhere('s.description LIKE :searchTerm')
                ->setParameter('searchTerm', '%'.$term.'%')
                ->getQuery()
                ->getResult();
        }
        return $this->createQueryBuilder('s')
            ->andWhere('s.title LIKE :searchTerm')
            ->orWhere('s.description LIKE :searchTerm')
            ->andWhere('s.service_field = :field')
            ->andWhere('s.county = :county')
            ->andWhere('s.city = :city')
            ->setParameter('searchTerm', '%'.$term.'%')
            ->setParameter('field', $field)
            ->setParameter('county', $county)
            ->setParameter('city', $city)
            ->getQuery()
            ->getResult();
    }

}
