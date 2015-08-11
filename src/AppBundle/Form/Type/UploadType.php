<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints;

/**
 * Class UploadType
 *
 * @package AppBundle\Form\Type
 */
class UploadType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('file', 'file', [
                    'label' => 'Archivo',
                    'constraints' => new Constraints\File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/octet-stream',
                            ],
                    ]),
                ])
                ->add('upload', 'submit', ['label' => 'Subir'])
        ;
    }

    /**
     * Gets Form name
     *
     * @return string
     */
    public function getName()
    {
        return 'upload_form';
    }
}
