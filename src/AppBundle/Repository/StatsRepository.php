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

    public function save(array  $data)
    {
        $query = $this->connection->prepare("INSERT INTO stats (`ip`,`browse`) VALUES (:ip, :browse)");
        $query->bindValue('ip',$data['ip']);
        $query->bindValue('browse',$data['browse']);
        $query->execute($data);
    }

    public function getBrowsers()
    {
        $query = $this->connection->prepare("SELECT count(1) as cnt, browse FROM stats GROUP BY browse");
        $query->execute();
        return $query->fetchAll();
    }
}