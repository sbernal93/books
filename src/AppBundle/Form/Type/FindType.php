<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Api;


/**
 * Class FindType
 *
 * @package AppBundle\Form\Type
 */
class FindType extends AbstractType
{
    protected $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
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

    /**
     * Gets all the API options from the database
     *
     * @return array
     */
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

    /**
     * Gets Form name
     *
     * @return string
     */
    public function getName()
    {
        return 'find_form';
    }
}
