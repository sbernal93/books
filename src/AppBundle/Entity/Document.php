<?php

/**
 * Created by PhpStorm.
 * User: Santiago
 * Date: 7/31/2015
 * Time: 9:41 AM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Document
 *
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="documents")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Doctrine\Orm\DocumentsRepository")
 * @UniqueEntity("name")
 */
class Document
{
    /**
     * @ORM\Column(name="doc_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(name="doc_name", type="string", length=80, nullable=false)
     *
     * @var string
     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="Book")
     * @ORM\JoinTable(name="lb_doc",
     *                  joinColumns={@ORM\JoinColumn(name="doc_id_fk", referencedColumnName="doc_id")},
     *                  inverseJoinColumns={@ORM\JoinColumn(name="lb_id_fk", referencedColumnName="LB_id")}
     *               )
     *
     * @var ArrayCollection
     */
    protected $books;

    /**
     * Document constructor.
     *
     */
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
     * @return ArrayCollection
     */
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * @param Book $book
     */
    public function addBook(Book $book)
    {
        $this->books->add($book);
    }
    /**
     * @param Book $book
     */
    public function removeBook(Book $book)
    {
        $this->books->removeElement($book);
    }


}