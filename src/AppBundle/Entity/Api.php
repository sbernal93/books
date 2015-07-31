<?php
/**
 * Created by PhpStorm.
 * User: Santiago
 * Date: 7/31/2015
 * Time: 11:47 AM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Api
 *
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="books_api")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Doctrine\Orm\ApiRepository)
 * @UniqueEntity("name")
 */
class Api
{
    /**
     * @ORM\Column(name="BA_id", type="integer")
     * @ORM\id
     * @ORM\GenerateValue(strategy="IDENTITY")
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(name="BA_name", type="string", length="60")
     *
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(name="BA_key", type="string", length="50")
     *
     * @var string
     */
    protected $key;

    /**
     * @ORM\Column(name="BA_classname", type="string", length="30")
     *
     * @var string
     */
    protected $adapterName;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getAdapterName()
    {
        return $this->adapterName;
    }

    /**
     * @param string $adapterName
     */
    public function setAdapterName($adapterName)
    {
        $this->adapterName = $adapterName;
    }


}