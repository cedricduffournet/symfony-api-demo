<?php

namespace App\Form\Type;

use App\Form\DataTransformer\SimpleMoneyToArrayTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Tbbc\MoneyBundle\Pair\PairManagerInterface;

/**
 * Form type for the Money object.
 */
class SimpleMoneyType extends MoneyType
{
    /** @var PairManagerInterface */
    protected $pairManager;

    /** @var int */
    protected $decimals;

    /**
     * SimpleMoneyType constructor.
     *
     * @param int $decimals
     */
    public function __construct(PairManagerInterface $pairManager, $decimals)
    {
        $this->pairManager = $pairManager;
        $this->decimals = (int) $decimals;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            ->addModelTransformer(
                new SimpleMoneyToArrayTransformer($this->pairManager, $this->decimals)
            );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tbbc_simple_money';
    }
}
