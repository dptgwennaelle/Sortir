<?php

namespace App\Repository;

use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sortie>
 *
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function findFilteredSorties(array $criteria)
    {
        // Implémentez la logique de filtrage ici en fonction des critères fournis.
        // Retournez un tableau de sorties filtrées.

        // Exemple simple (vous devez adapter cela en fonction de votre modèle de données) :
        $queryBuilder = $this->createQueryBuilder('s');

        if (!empty($criteria['campus'])) {
            $queryBuilder->andWhere('s.campus = :campus')->setParameter('campus', $criteria['campus']);
        }

        if (!empty($criteria['nom'])) {
            $queryBuilder->andWhere('s.nom LIKE :nom')->setParameter('nom', '%' . $criteria['nom'] . '%');
        }

        // ... Ajoutez d'autres conditions en fonction des autres critères.

        return $queryBuilder->getQuery()->getResult();
    }
}
