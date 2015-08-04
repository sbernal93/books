<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Api;

/**
 * Description of SearchForm.
 *
 * @author recchia
 */
class FindType extends AbstractType
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'isbn',
                'text',
                [
                    'label' => 'ISBN: ',
                    'constraints' => new Constraints\NotBlank(['message' => 'El campo ISBN es obligatorio'])
                ]
            )
            ->add(
                'api',
                'choice',
                [
                    'choices' => ['APis' => $this->fillApiChoice()],
                    'label' => 'Api'
                ]
            )
            ->add('search', 'submit', ['label' => 'Buscar']);
    }

    public function fillApiChoice()
    {
        $apiRepository = $this->entityManager->getRepository('AppBundle:Api');

        $apis = $apiRepository->findAll();

        $apiArray = array();

        foreach($apis as $api)
        {
            $apiArray[$api->getName()] = $api->getName();
        }

        return $apiArray;
    }

    public function getName()
    {
        return 'find_form';
    }
}
