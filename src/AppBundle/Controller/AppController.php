<?php

/**
 * Created by PhpStorm.
 * User: Santiago
 * Date: 7/31/2015
 * Time: 8:59 AM
 */


namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class AppController extends Controller
{
    /**
     * @Route("/find")
     *
     * @return JsonResponse
     */
    public function findOneBook()
    {

    }

    /**
     * @Route("/upload")
     *
     * @return JsonResponse
     */
    public function uploadDocument()
    {

    }

    /**
     * @Route("/download")
     *
     * @return JsonResponse
     */
    public function downloadDocument()
    {

    }
}