<?php

/**
 * Created by PhpStorm.
 * User: Santiago
 * Date: 7/28/2015
 * Time: 10:28 AM
 */

namespace AppBundle\Form\EventListener;

use Proxies\__CG__\AppBundle\Entity\Api;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Document;

class AddDocumentFieldSuscriber implements EventSubscriberInterface
{


    private $factory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }


    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_BIND => 'preBind'
        );
    }

    private function addDocumentForm($form, $document)
    {

        $form->add($this->factory->createNamed('files', 'choice', null, array(
            'empty_value' => 'Empty',
            'auto_initialize' => false,
            'query_builder' => function (EntityRepository $repository) use ($document) {
                $qb = $repository->createQueryBuilder('documents');
                if ($document instanceof Document) {
                    $qb->where('document.doc_name = :document')
                        ->setParameter('document', $document->getName());
                } elseif (is_numeric($document)) {
                    $qb->where('document.doc_id = :document')
                        ->setParameter('document', $document);
                } else {
                    $qb->where('document.name = :document')
                        ->setParameter('document', null);
                }
                return $qb;
            }
        )));
    }

    public function preSetData(FormEvent $event) {
        $data = $event->getData();

        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $document =  ($data->getDocument()) ? $data->getDocument() : null;

        $this->addDocumentForm($form, $document);
    }

    public function preBind(FormEvent $event) {
        $data = $event->getData();

        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $document = array_key_exists('files', $data) ? $data['files'] : null;

        $this->addDocumentForm($form, $document);
    }
}