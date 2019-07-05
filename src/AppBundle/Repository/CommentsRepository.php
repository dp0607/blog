<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

class StatsRepository extends EntityRepository
{

    private $connection;

    public function __construct($em, Mapping\ClassMetadata $class)
    {
        parent::__construct($em, $class);
        $this->connection = $em->getConnection();
    }

    public function getComments($type, $entity)
    {
        $query = $this->connection->prepare("SELECT * FROM comments WHERE `type` = :type AND `entity_id` = :entity");
        $query->bindValue('type',$type);
        $query->bindValue('entity',$entity);
        $query->execute();
        return $query->fetchAll();
    }

}