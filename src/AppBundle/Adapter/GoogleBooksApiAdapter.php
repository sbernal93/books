<?php

namespace AppBundle\Adapter;

use AppBundle\Interfaces\AdapterInterface;
use AppBundle\Exception\ApiException;
use AppBundle\Entity\Book;
use Google_Client;
use Google_Service_Books;
use Google_Service_Exception;
use AppBundle\Exception\BookNotFoundException;
use AppBundle\Model\Constants;
use Symfony\Component\Config\Definition\Exception\Exception;

class GoogleBooksApiAdapter implements AdapterInterface
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
    {
        $this->client = new Google_Client();
        $this->client->setApplicationName('');
        $this->client->setDeveloperKey($config[Constants::GOOGLE_BOOKS_LABEL_API_KEY]);
        $this->booksApi = new Google_Service_Books($this->client);
        $this->params[Constants::GOOGLE_BOOKS_LABEL_LANGRES] = Constants::GOOGLE_BOOKS_LANGRESTRICT;
    }

    /**
     * Searches for a book in the Google Books API by using its isbn
     *
     * @param $isbn
     * @return Book
     *
     * @throws ApiException
     * @throws BookNotFoundException
     */
    public function findOne($isbn)
    {
        try {
            $q = Constants::GOOGLE_BOOKS_QUERY . $isbn;
            $result = $this->booksApi->volumes->listVolumes($q, $this->params);
            $items = $result->getItems();
            if (count($items) > 0) {
                $volumeInfo = $items[0]->getVolumeInfo();

                return $this->buildBookWithApiInfo($volumeInfo);
            } else {
                throw new BookNotFoundException("Google Book Api can't find ISBN: " . $isbn);
            }
        } catch (Google_Service_Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * Finds a book array from an isbn array using the Google Books API
     *
     * @param array $isbns
     *
     * @return array
     */
    public function find(array &$isbns)
    {
        $data = [];
        $isbnsNotFound = [];
        try {
            if (is_array($isbns)) {

                foreach ($isbns as $isbn) {
                    $q = Constants::GOOGLE_BOOKS_QUERY . $isbn;
                    $result = $this->booksApi->volumes->listVolumes($q, $this->params);
                    $items = $result->getItems();
                    if (count($items) > 0) {
                        $volumeInfo = $items[0]->getVolumeInfo();
                        $book = $this->buildBookWithApiInfo($volumeInfo);
                        $data[] = $book;
                    }
                    else
                    {
                        $isbnsNotFound[] = $isbn;
                    }
                }

                $isbns = $isbnsNotFound;
                return $data;
            }
        }
        catch(Exception $e)
        {
            //TODO: catch specific exception
            return $data;
        }

    }

    /**
     * Builds a Book entity from the data retrieved from the API
     *
     * @param $volumeInfo
     *
     * @return Book
     */
    public function buildBookWithApiInfo($volumeInfo)
    {
        $numIsbn13 = 0;
        $numIsbn10 = 1;
        if(strlen($volumeInfo[Constants::GOOGLE_BOOKS_LABEL_INDUSTRY][0][Constants::GOOGLE_BOOKS_LABEL_IDENTIFIER]) != 13) {
            $numIsbn10 = 0;
            $numIsbn13 = 1;
        }

        if (isset($volumeInfo[Constants::GOOGLE_BOOKS_LABEL_INDUSTRY][$numIsbn13])) {
            $isbn13 = $volumeInfo[Constants::GOOGLE_BOOKS_LABEL_INDUSTRY][$numIsbn13][Constants::GOOGLE_BOOKS_LABEL_IDENTIFIER];
        }
        else
        {
            $isbn13 = "N/A";
        }
        if (isset($volumeInfo[Constants::GOOGLE_BOOKS_LABEL_INDUSTRY][$numIsbn10])) {
            $isbn10 = $volumeInfo[Constants::GOOGLE_BOOKS_LABEL_INDUSTRY][$numIsbn10][Constants::GOOGLE_BOOKS_LABEL_IDENTIFIER];
        }
        else
        {
            $isbn10 = "N/A";
        }

        $author = (is_array($volumeInfo[Constants::GOOGLE_BOOKS_LABEL_AUTHORS])) ?
            implode(', ', $volumeInfo[Constants::GOOGLE_BOOKS_LABEL_AUTHORS]) :
            $volumeInfo[Constants::GOOGLE_BOOKS_LABEL_AUTHORS];


        $imageLink = (!empty($volumeInfo[Constants::GOOGLE_BOOKS_LABEL_IMAGELINKS][Constants::GOOGLE_BOOKS_LABEL_THUMBNAIL]))
            ? $volumeInfo[Constants::GOOGLE_BOOKS_LABEL_IMAGELINKS][Constants::GOOGLE_BOOKS_LABEL_THUMBNAIL] : '';


        $book = Book::buildComplete(
            $isbn10,
            $isbn13,
            $volumeInfo[Constants::GOOGLE_BOOKS_LABEL_TITLE],
            $author,
            $volumeInfo[Constants::GOOGLE_BOOKS_LABEL_PUBLISHER],
            $volumeInfo[Constants::GOOGLE_BOOKS_LABEL_DESCRIPTION],
            $volumeInfo[Constants::GOOGLE_BOOKS_LABEL_PAGECOUNT],
            $imageLink
        );
        return $book;
    }

}