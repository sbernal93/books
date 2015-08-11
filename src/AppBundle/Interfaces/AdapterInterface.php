<?php

namespace AppBundle\Interfaces;

use AppBundle\Exception\BookNotFoundException;

/**
 * Interface AdapterInterface
 *
 * @package AppBundle\Interfaces
 */
interface AdapterInterface
{
    /**
     * @param array $config
     */
    public function __construct(array $config);

    /**
     * @param $isbn
     *
     * @return array
     *
     * @throws BookNotFoundException
     */
    public function findOne($isbn);

    /**
     * @param array $isbns
     *
     * @return array
     */
    public function find(array &$isbns);
}