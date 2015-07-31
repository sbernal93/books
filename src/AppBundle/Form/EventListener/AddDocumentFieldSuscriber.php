<?php

/**
 * Created by PhpStorm.
 * User: Santiago
 * Date: 7/28/2015
 * Time: 10:28 AM
 */

namespace AppBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

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

       /* $form->add($this->factory->createNamed('files', 'choice', null, array(
            'empty_value' => 'Empty',
            'auto_initialize' => false,
            'choices' => ['Files' => $qb]
        )));
        /*$form->add($this->factory->createNamed('files', 'choice', null, [
            'choices' => ['Files' => $document],
            'label' => 'Files',
        ]));*/
    }

    public function preSetData(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();
        if (null === $data) {
            return;
        }
        $document = array_key_exists('files', $data) ? $data['files'] : null;
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