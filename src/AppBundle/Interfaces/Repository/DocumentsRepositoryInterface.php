<?php
/**
 * Created by PhpStorm.
 * User: Santiago
 * Date: 7/31/2015
 * Time: 9:47 AM
 */

namespace AppBundle\Interfaces\Repository;

use AppBundle\Interfaces\RepositoryInterface;

interface DocumentsRepositoryInterface extends RepositoryInterface
{
    /**
     * @param $filename
     * @param array $isbns
     * @return boolean
     */
    public function saveFilesWithIsbns($filename, array $isbns);

    /**
     * @param $docName
     * @return array
     */
    public function getBooksFromDocument($docName);
}