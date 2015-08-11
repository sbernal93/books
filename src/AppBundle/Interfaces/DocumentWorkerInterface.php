<?php
/**
 * Created by PhpStorm.
 * User: Santiago
 * Date: 8/4/2015
 * Time: 12:19 PM
 */

namespace AppBundle\Interfaces;

interface DocumentWorkerInterface
{
    /**
     * @param array $config
     */
    public function __construct(array $config = null);

    /**
     * @param $filename
     * @param array $info
     *
     * @return mixed
     */
    public function createDocument($filename, array $info=null);

    /**
     * @param array $info
     * @param $file
     * @param $filename
     * @param $path
     *
     * @return mixed
     */
    public function fillDocument(array $info, $file, $filename, $path);

    /**
     * @param $file
     * @param $path
     * @param $filename
     *
     * @return array
     */
    public function getISBNSFromDocument($file, $path, $filename);
}