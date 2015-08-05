<?php
/**
 * Created by PhpStorm.
 * User: Santiago
 * Date: 7/31/2015
 * Time: 9:45 AM
 */

namespace AppBundle\Repository\Doctrine\Orm;

use AppBundle\Interfaces\Repository\BooksRepositoryInterface;

class BooksRepository extends AbstractBaseRepository implements BooksRepositoryInterface
{
    /**
     * @param array $isbns
     *
     * @return array
     */
    public function findISBNSNotInDatabase(array $isbns)
    {
        $isbnsNotFound = [];

        foreach ($isbns as $isbn)
        {
            if (!$this->findBy(array('isbn13' => $isbn)))
            {
                $isbnsNotFound[] = $isbn;
            }
        }
        return $isbnsNotFound;
    }
}