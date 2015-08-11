<?php

/**
 * Created by PhpStorm.
 * User: Santiago
 * Date: 7/31/2015
 * Time: 9:41 AM
 */
namespace AppBundle\Entity;

use AppBundle\AppBundle;
use AppBundle\Model\Constants;
use AppBundle\Entity\Author;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Tests\Fixtures\Entity;

/**
 * Class Book
 *
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="linio_books")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Doctrine\Orm\BooksRepository")
 * @UniqueEntity("isbn10")
 * @UniqueEntity("isbn13")
 *
 */
class Book
{
    /**
     * @ORM\Column(name="LB_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @var int
     */
    protected $id;
    /**
     * @ORM\Column(name="LB_isbnTen", type="string", length=11, nullable=false)
     *
     * @var string
     */
    protected $isbn10;

    /**
     * @ORM\Column(name="LB_isbnThirteen", type="string", length=14, nullable=false)
     *
     * @var string
     */
    protected $isbn13;

    /**
     * @ORM\Column(name="LB_title", type="string", length=100, nullable=false)
     *
     * @var string
     */
    protected $title;

    /**
     * @ORM\ManyToMany(targetEntity="Author", inversedBy="author")
     * @ORM\JoinTable(name="lb_author",
     *              joinColumns={@ORM\JoinColumn(name="lb_id_fk", referencedColumnName="book_id")},
     *              inverseJoinColumns={@ORM\JoinColumn(name="auth_id_fk", referencedColumnName="auth_id")}
     *              )
     *
     * @var ArrayCollection
     */
    protected $authors;

    /**
     * @ORM\Column(name="LB_publisher", type="string", length=100)
     *
     * @var string
     */
    protected $publisher;

    /**
     * @ORM\Column(name="LB_description", type="string", length=500)
     *
     * @var string
     */
    protected $description;

    /**
     * @ORM\Column(name="LB_pages", type="integer")
     *
     * @var string
     */
    protected $pageCount;

    /**
     * @ORM\Column(name="LB_imageLink", type="string", length=50)
     *
     * @var string
     */
    protected $imageLink;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }

    /**
     * @param $isbn10
     * @param $isbn13
     * @param $title
     * @param $authors
     * @param $publisher
     * @param $description
     * @param $pageCount
     * @param $imageLink
     *
     * @return Book
     */
    public static function buildComplete($isbn10, $isbn13, $title, $authors, $publisher, $description, $pageCount, $imageLink)
    {

        $instance = new self();
        $instance->setIsbn10($isbn10);
        $instance->setIsbn13($isbn13);
        $instance->setTitle($title);
        $instance->setAuthors($authors);
        $instance->setPublisher($publisher);
        $instance->setDescription($description);
        $instance->setPageCount($pageCount);
        $instance->setImageLink($imageLink);
        return $instance;
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
    public function getIsbn10()
    {
        return $this->isbn10;
    }

    /**
     * @param string $isbn10
     */
    public function setIsbn10($isbn10)
    {
        if (is_null($isbn10))
        {
            $this->isbn10 = "N/A";
        }
        else {
            $this->isbn10 = $isbn10;
        }
    }

    /**
     * @return string
     */
    public function getIsbn13()
    {
        return $this->isbn13;
    }

    /**
     * @param string $isbn13
     */
    public function setIsbn13($isbn13)
    {
        if (is_null($isbn13))
        {
            $this->isbn13 = "N/A";
        }
        else {
            $this->isbn13 = $isbn13;
        }
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        if (is_null($title))
        {
            $this->title = "N/A";
        }
        else {
            $this->title = trim($title,"'");
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * @param ArrayCollection $authors
     */
    public function setAuthors($authors)
    {
        if (is_null($authors))
        {
            $author = new Author();
            $author->setName('N/A');
            $this->authors = $author;
        }
        else {
            $this->authors = $authors;
        }
    }

    /**
     * @return string
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @param string $publisher
     */
    public function setPublisher($publisher)
    {
        if (is_null($publisher))
        {
            $this->publisher = "N/A";
        }
        else {
            $this->publisher = $publisher;
        }
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        if (is_null($description))
        {
            $this->description = "N/A";
        }
        else {
            $this->description = $description;
        }
    }

    /**
     * @return string
     */
    public function getPageCount()
    {
        return $this->pageCount;
    }

    /**
     * @param string $pageCount
     */
    public function setPageCount($pageCount)
    {
        if (is_null($pageCount))
        {
            $this->pageCount = "N/A";
        }
        else {
            $this->pageCount = $pageCount;
        }
    }

    /**
     * @return string
     */
    public function getImageLink()
    {
        return $this->imageLink;
    }

    /**
     * @param string $imageLink
     */
    public function setImageLink($imageLink)
    {
        if (is_null($imageLink))
        {
            $this->imageLink = "N/A";
        }
        else {
            $this->imageLink = $imageLink;
        }
    }
}