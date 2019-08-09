<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file',
                FileType::class,
                [
                    'label'         => 'Image',
                    'required'      => false,
                    'mapped'        => false,
                    'constraints'   => [
                    new File([
                        'maxSize'   => '2M',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/pjpeg',
                        ],

                        'mimeTypesMessage' => 'Please upload a valid image',
                    ]),
                ],
                ]
            );
    }
}
