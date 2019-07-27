<?php

namespace App\Form\Type;

use App\Form\DataTransformer\MoneyToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Form type for the Money object.
 */
class MoneyType extends AbstractType
{
    /** @var int */
    protected $decimals;

    /**
     * MoneyType constructor.
     *
     * @param int $decimals
     */
    public function __construct($decimals)
    {
        $this->decimals = (int) $decimals;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('currency', $options['currency_type'])
            ->addModelTransformer(
                new MoneyToArrayTransformer($this->decimals)
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class'    => null,
                'currency_type' => 'Tbbc\MoneyBundle\Form\Type\CurrencyType',
            ])
            ->setAllowedTypes(
                'currency_type',
                [
                    'string',
                    'Tbbc\MoneyBundle\Form\Type\CurrencyType',
                ]
            );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tbbc_money';
    }
}
