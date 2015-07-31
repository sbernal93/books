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
     * @Route("/", method={"GET"})
     *
     */
    public function homepageAction()
    {

    }

    /**
     * @Route("/find", method={"POST"})
     *
     * @return JsonResponse
     */
    public function findOneBook()
    {

    }

    /**
     * @Route("/upload", method={"POST"})
     *
     * @return JsonResponse
     */
    public function uploadDocument()
    {

    }

    /**
     * @Route("/download", method={"POST"})
     *
     * @return JsonResponse
     */
    public function downloadDocument()
    {

    }
}