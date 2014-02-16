<?php

namespace Afup\DirectoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table(name="afup_pays")
 * @ORM\Entity
 */
class Country
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=2)
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50)
     */
    private $name;


    /**
     * Set name
     *
     * @param string $name
     * @return Country
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set id
     *
     * @param string $id
     * @return Country
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }
}
