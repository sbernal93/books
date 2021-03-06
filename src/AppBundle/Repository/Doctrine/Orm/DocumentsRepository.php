<?php

namespace AppBundle\Repository\Doctrine\Orm;

use AppBundle\Entity\Book;
use AppBundle\Exception\BookNotFoundException;
use AppBundle\Exception\DocumentNotFoundException;
use AppBundle\Interfaces\Repository\DocumentsRepositoryInterface;
use AppBundle\Entity\Document;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Model\Constants;

/**
 * Class DocumentsRepository
 *
 * @package AppBundle\Repository\Doctrine\Orm
 */
class DocumentsRepository extends AbstractBaseRepository implements DocumentsRepositoryInterface
{
    /**
     * Stores a document and its isbns in the database
     *
     * @param $filename
     * @param array $isbns
     * @return boolean
     */
    public function saveDocumentWithIsbns($filename, array $isbns)
    {
        if(!is_null($filename && !is_null($isbns)))
        {
            $file = new Document();

            $file->setName($filename);
            $bookArray = [];
            foreach ($isbns as $isbn)
            {
                $bookRepo = $this->_em->getRepository('AppBundle:Book');
                $book = $bookRepo->findBy(array('isbn13' => $isbn));

                if (!is_null($book) && array_key_exists(0, $book)) {
                    $bookArray[] = $book[0];
                    //$file->addBook($book[0]);
                }

            }
            $bookArray = $this->deleteRepeatedBooksInArray($bookArray);

            foreach($bookArray as $book)
            {
                $file->addBook($book);
            }

            $this->add($file);

            return true;
        }
        return false;
    }

    /**
     * Deletes repeated books in an array
     *
     * @param $bookArray
     *
     * @return array
     */
    public function deleteRepeatedBooksInArray($bookArray)
    {
        $bookArrayWithoutRepeat = [];

        foreach($bookArray as $book)
        {
            if (!in_array($book, $bookArrayWithoutRepeat))
            {
                $bookArrayWithoutRepeat[] = $book;
            }
        }
        return $bookArrayWithoutRepeat;
    }

    /**
     * Gets all the books given a documents name
     *
     * @param $docName
     *
     * @return array
     *
     * @throws DocumentNotFoundException
     */
    public function getBooksFromDocument($docName)
    {
        if (!is_null($docName) && $this->findBy(array('name' => $docName)))
        {
            $sql = "SELECT lb.*, auth.auth_name
                    FROM linio_books AS lb,"
                .   "author AS auth, "
                .   "lb_author AS lba, "
                .   "documents AS doc, "
                .   "lb_doc AS lbd ".
                "WHERE doc.doc_name =? AND ".
                "doc.doc_id = lbd.doc_id_fk AND ".
                "lb.lb_id = lbd.lb_id_fk AND ".
                "lba.lb_id_fk = lb.lb_id AND ".
                "lba.auth_id_fk = auth.auth_id";
            $booksDBArray = $this->_em->getConnection()->fetchAll($sql, array($docName));
            $booksArray = [];
            foreach ($booksDBArray as $bookDB)
            {
                $book = Book::buildComplete(
                    $bookDB[Constants::BOOK_ISBN10],
                    $bookDB[Constants::BOOK_ISBN13],
                    $bookDB[Constants::BOOK_TITLE],
                    $bookDB[Constants::AUTHOR_NAME],
                    $bookDB[Constants::BOOK_PUBLISHER],
                    $bookDB[Constants::BOOK_DESCRIPTION],
                    $bookDB[Constants::BOOK_NUMPAGES],
                    $bookDB[Constants::BOOK_IMAGELINK]
                );
                $booksArray[] = $book;
            }
            return $booksArray;

        }
        throw new DocumentNotFoundException('Document not found in database');
    }


}