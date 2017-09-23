<?php

namespace Test\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections;
use Test\AppBundle\Entity\Type;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Test\AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var ArrayCollection Type $types
     * @ORM\ManyToMany(targetEntity="Type", mappedBy="users", cascade={"persist", "merge"})
     */
    private $types;

    public function __construct()
    {
        parent::__construct();
        //$this->types = new ArrayCollection();
    }

    /**
     * Add type
     *
     * @param \Test\AppBundle\Entity\Type $type
     *
     * @return User
     */
    public function addType(\Test\AppBundle\Entity\Type $type)
    {
        $this->types[] = $type;

        return $this;
    }
    
    public function setType($types)
    {
        if ($types instanceof ArrayCollection || is_array($types)) {
            foreach ($types as $type) {
                $this->addTypeAction($type);
            }
        }
        else if ($types instanceof Type) {
            $this->addTypeAction($types);
        }
        else {
            throw new Exception("$types doit être une instance de TypeAction ou ArrayCollection");
        }
    }

    /**
     * Remove type
     *
     * @param \Test\AppBundle\Entity\Type $type
     */
    public function removeType(\Test\AppBundle\Entity\Type $type)
    {
        $this->types->removeElement($type);
    }

    /**
     * Get types
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTypes()
    {
        return $this->types;
    }
    
    
}
