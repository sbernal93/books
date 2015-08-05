<?php
/**
 * Created by PhpStorm.
 * User: Santiago
 * Date: 7/31/2015
 * Time: 10:50 AM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Author
 *
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="author")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Doctrine\Orm\AuthorsRepository")
 * @UniqueEntity("name")
 */
class Author
{
    /**
     * @ORM\Column(name="auth_id", type="integer")
     * @ORM\id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(name="auth_name", type="string", length=80, nullable=false)
     *
     * @var string
     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="Book", mappedBy="books")
     *
     * @var array
     */
    protected $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

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
     * @return array
     */
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * @param array $books
     */
    public function setBooks($books)
    {
        $this->books = $books;
    }


}