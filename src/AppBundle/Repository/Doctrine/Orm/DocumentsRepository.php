<?php
/**
 * Created by PhpStorm.
 * User: Santiago
 * Date: 7/31/2015
 * Time: 9:45 AM
 */

namespace AppBundle\Repository\Doctrine\Orm;

use AppBundle\Entity\Book;
use AppBundle\Exception\BookNotFoundException;
use AppBundle\Exception\DocumentNotFoundException;
use AppBundle\Interfaces\Repository\DocumentsRepositoryInterface;
use AppBundle\Entity\Document;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Model\Constants;

class DocumentsRepository extends AbstractBaseRepository implements DocumentsRepositoryInterface
{
    /**
     * @param $filename
     * @param array $isbns
     * @return boolean
     */
    public function saveFilesWithIsbns($filename, array $isbns)
    {
        if(!is_null($filename && !is_null($isbns)))
        {
            $file = new Document();

            $file->setName($filename);
            foreach ($isbns as $isbn)
            {
                $bookRepo = $this->_em->getRepository('AppBundle:Book');
                $book = $bookRepo->findBy(array('isbn13' => $isbn));
                if (!is_null($book) && array_key_exists(0, $book)) {
                    $file->addBook($book[0]);
                }

            }

            $this->add($file);

            return true;
        }
        return false;
    }

    /**
     * @param $docName
     * @return array
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