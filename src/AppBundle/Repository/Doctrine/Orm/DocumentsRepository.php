<?php
/**
 * Created by PhpStorm.
 * User: Santiago
 * Date: 7/31/2015
 * Time: 9:45 AM
 */

namespace AppBundle\Repository\Doctrine\Orm;

use AppBundle\Entity\Book;
use AppBundle\Interfaces\Repository\DocumentsRepositoryInterface;
use AppBundle\Entity\Document;
use Doctrine\Common\Collections\ArrayCollection;

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

}