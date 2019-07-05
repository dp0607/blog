<?php

namespace AppBundle\Entity;

/**
 * Stats
 */
class Stats
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var string
     */
    private $browse;

    /**
     * @var \DateTime
     */
    private $createdAt = 'CURRENT_TIMESTAMP';


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return Stats
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set browse
     *
     * @param string $browse
     *
     * @return Stats
     */
    public function setBrowse($browse)
    {
        $this->browse = $browse;

        return $this;
    }

    /**
     * Get browse
     *
     * @return string
     */
    public function getBrowse()
    {
        return $this->browse;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Stats
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}

