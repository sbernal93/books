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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\FindType;
use AppBundle\Form\Type\DownloadType;
use AppBundle\Form\Type\UploadType;
use AppBundle\Repository\Doctrine\Orm\ApiRepository;

/**
 * Class AppController
 *
 * @package AppBundle\Controller
 *
 * @Route("/")
 */
class AppController extends Controller
{

    /**
     * @Route("/")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $apis = $em->getRepository('AppBundle:Api')->findAll();
        $documents = $em->getRepository('AppBundle:Document')->findAll();
        $form = $this->createForm(new FindType($apis))->createView();
        $upload = $this->createForm(new UploadType())->createView();
        $download = $this->createForm(new DownloadType($documents))->createView();

        return $this->render('books/index.html.twig', [
            'form' => $form, 'upload' => $upload, 'download' => $download
        ]);
    }

    /**
     * @Route("/find")
     * @Method("POST")
     *
     * @return JsonResponse
     */
    public function findOneBook()
    {

    }

    /**
     * @Route("/upload")
     * @Method("POST")
     *
     * @return JsonResponse
     */
    public function uploadDocument()
    {

    }

    /**
     * @Route("/download")
     * @Method("POST")
     *
     * @return JsonResponse
     */
    public function downloadDocument()
    {

    }
}