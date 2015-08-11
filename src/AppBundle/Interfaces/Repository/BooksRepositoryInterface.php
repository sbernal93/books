<?php

namespace AppBundle\Interfaces\Repository;

use AppBundle\Interfaces\RepositoryInterface;

/**
 * Interface BooksRepositoryInterface
 *
 * @package AppBundle\Interfaces\Repository
 */
interface BooksRepositoryInterface extends RepositoryInterface
{
    /**
     * @param array $isbns
     *
     * @return array
     */
    public function findISBNSNotInDatabase(array $isbns);

}