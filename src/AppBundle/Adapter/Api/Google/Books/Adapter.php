<?php

namespace AppBundle\Adapter\Api\Google\Books;

use AppBundle\Interfaces\AdapterInterface;
use Google_Client;
use Google_Service_Books;

class Adapter implements AdapterInterface
{
    /**
     * @var Google_Client
     */
    protected $client;

    /**
     * @var Google_Service_Books
     */
    protected $booksApi;

    /**
     * @var array
     */
    protected $params = [];

    public function __construct(array $config)
    {}

    public function findOne($isbn)
    {}

    public function find(array $isbns)
    {}
}