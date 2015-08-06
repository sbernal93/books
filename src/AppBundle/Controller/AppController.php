<?php

/**
 * Created by PhpStorm.
 * User: Santiago
 * Date: 7/31/2015
 * Time: 8:59 AM
 */


namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Api;
use AppBundle\Entity\Document;
use AppBundle\Exception\DocumentNotFoundException;
use AppBundle\Model\Constants;
use AppBundle\Model\MessageBuilder;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Exception;
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
use AppBundle\Exception\BookNotFoundException;
use AppBundle\Interfaces\AdapterInterface;
use AppBundle\DocumentWorker\ExcelWorker;

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
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(new FindType($entityManager))->createView();
        $upload = $this->createForm(new UploadType())->createView();
        $download = $this->createForm(new DownloadType($entityManager))->createView();

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
    public function findOneBook(Request $request)
    {
        try {
            $entityManager = $this->getDoctrine()->getManager();

            $form = $this->createForm(new FindType($entityManager));
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();

                $apiRepository = $entityManager->getRepository('AppBundle:Api');
                $apiInfo = $apiRepository->findBy(array('name' =>  $data['api']));

                $class = 'AppBundle\\Adapter\\' . $apiInfo[0]->getAdapterName();
                $adapter = new $class([Constants::GOOGLE_BOOKS_LABEL_API_KEY => $apiInfo[0]->getKey()]);

                $book = $adapter->findOne($data['isbn']);
                if ($request->isXmlHttpRequest()) {

                    return new JsonResponse( MessageBuilder::getFindOneBookReturnMessage($book));
                } else {

                    return $this->render('books/show.html.twig', ['books' => $book]);
                }
            }
        }
        catch (BookNotFoundException $e)
        {
            return new JsonResponse(MessageBuilder::getBookNotFoundExceptionMessage());
        }
    }

    /**
     * @Route("/upload")
     * @Method("POST")
     *
     * @return JsonResponse
     */
    public function uploadDocument(Request $request)
    {
        try {
            ini_set('max_execution_time', 100000);
            $upload = $this->createForm(new UploadType());
            $upload->handleRequest($request);

            if ($upload->isValid()) {
                $file = $request->files->get($upload->getName());

                $path = $this->get('kernel')->getRootDir() . '/../web/upload' . $this->getRequest()->getBasePath();
                $path = $path .'/';

                $filename = $file['file']->getClientOriginalName();

                $excelWorker = new ExcelWorker();
                $isbns = $excelWorker->getISBNSFromDocument($file, $path, $filename);

                $entityManager = $this->getDoctrine()->getManager();
                $apiRepository = $entityManager->getRepository('AppBundle:Api');
                $documentRepository = $entityManager->getRepository('AppBundle:Document');
                $bookRepository = $entityManager->getRepository('AppBundle:Book');

                $isbnsNotFound = $bookRepository->findISBNSNotInDatabase($isbns);

                $apiArray = $apiRepository->findAll();
                $count = 0;
                $booksFound = [];
                foreach($apiArray as $api)
                {
                    if (!is_null($isbnsNotFound))
                    {
                        $class = 'AppBundle\\Adapter\\' . $api->getAdapterName();
                        $adapter = new $class([Constants::GOOGLE_BOOKS_LABEL_API_KEY => $api->getKey()]);
                        $booksFound = $adapter->find($isbnsNotFound);
                    }

                    $authorsRepository = $entityManager->getRepository('AppBundle:Author');

                    foreach($booksFound as $book)
                    {
                        if(!$bookRepository->findBy(array('isbn13' => $book->getIsbn13()))) {
                            $author = $authorsRepository->findBy(array('name' => $book->getAuthors()));
                            $authorcol = new ArrayCollection($author);
                            $book->setAuthors($authorcol);

                            $bookRepository->add($book);
                        }

                    }

                    $count++;
                    //TODO: Update the isbnsNotFound Array with the isbns that where found
                }

                $filename= trim($filename,".xlsx") . time() . ".xlsx";
                $documentRepository->saveFilesWithIsbns($filename, $isbns);

                return new JsonResponse(MessageBuilder::getUploaderReturnMessage($filename));
            } else {
                return new JsonResponse(
                    json_encode(['response' => 'File is invalid!', 'errors' => MessageBuilder::getFormErrorMessages($upload)])
                );
            }
        }
        catch (Exception $e)
        {
            return new JsonResponse($e->getMessage());
        }
    }

    /**
     * @Route("/download")
     * @Method("POST")
     *
     * @return JsonResponse
     */
    public function downloadDocument(Request $request)
    {
        try
        {
            ini_set('max_execution_time', 100000);

            $entityManager = $this->getDoctrine()->getManager();


            $downloadForm = $this->createForm(new DownloadType($entityManager));
            $downloadForm->handleRequest($request);
            //$download->bind($request);

            if ($downloadForm->isValid()){
                $data = $downloadForm->getData();
                $documentRepository = $entityManager->getRepository('AppBundle:Document');

                $docInfo = $documentRepository->findBy(array('name' => $data['files']));

                $books = $documentRepository->getBooksFromDocument($docInfo[0]->getName());

                $excel = new ExcelWorker();

                $path = $this->get('kernel')->getRootDir() . '/../web/upload' . $this->getRequest()->getBasePath();
                $path = $path .'/';

                $phpExcel = $excel->createDocument($docInfo[0]->getName());
                $excel->fillDocument($books, $phpExcel, $docInfo[0]->getName(), $path);

                return new JsonResponse(Constants::EXCEL_DOWNLOAD_LOCATION . $docInfo[0]->getName());
            } else {
                return new JsonResponse(
                    json_encode(['response' => 'File is invalid!', 'errors' => MessageBuilder::getFormErrorMessages($downloadForm)])
                );
            }
        }
        catch(DocumentNotFoundException $e)
        {
            return new JsonResponse(MessageBuilder::getDocumentNotFoundExceptionMessage());
        }
        catch (Exception $e)
        {
            return new JsonResponse($e->getMessage());
        }
    }
}