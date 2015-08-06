<?php
/**
 * Created by PhpStorm.
 * User: Santiago
 * Date: 7/17/2015
 * Time: 12:28 PM
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Validator\Constraints\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints;
use AppBundle\Form\EventListener\AddDocumentFieldSuscriber;
use Doctrine\ORM\EntityManager;

class DownloadType extends AbstractType
{

    protected $entityManager;


    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager=$entityManager;

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*$factory = $builder->getFormFactory();
        $documentSuscriber = new AddDocumentFieldSuscriber($factory);
        $builder->addEventSubscriber($documentSuscriber);*/

        $builder
            ->add('files', 'choice', [
                'choices' => ['Files' => $this->fillDocumentChoice()],
                'label' => 'Archivos: ',
            ])
            ->add('download', 'submit', ['label' => 'Descargar'])
        ;
    }

    public function fillDocumentChoice()
    {
        $documentRepository = $this->entityManager->getRepository('AppBundle:Document');

        $documents = $documentRepository->findAll();

        $documentArray = array();

        foreach($documents as $document)
        {
            $documentArray[$document->getName()] = $document->getName();
        }

        return $documentArray;
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'download_form';
    }
}