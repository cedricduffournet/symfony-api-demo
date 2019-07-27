<?php

namespace App\Form\DataTransformer;

use Money\Money;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Extension\Core\DataTransformer\MoneyToLocalizedStringTransformer;

/**
 * Transforms between a Money instance and an array.
 */
class MoneyToArrayTransformer implements DataTransformerInterface
{
    /** @var MoneyToLocalizedStringTransformer */
    protected $sfTransformer;

    /** @var int */
    protected $decimals;

    /**
     * MoneyToArrayTransformer constructor.
     *
     * @param int $decimals
     */
    public function __construct($decimals = 2)
    {
        $this->decimals = (int) $decimals;
        $this->sfTransformer = new MoneyToLocalizedStringTransformer($decimals, null, null, pow(10, $this->decimals));
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if (null === $value) {
            return;
        }

        if (!$value instanceof Money) {
            throw new UnexpectedTypeException($value, 'Money');
        }

        $amount = $this->sfTransformer->transform($value->getAmount());

        return [
            'amount'   => $amount,
            'currency' => $value->getCurrency(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        if (null === $value) {
            return;
        }
        if (!is_array($value)) {
            throw new UnexpectedTypeException($value, 'array');
        }
        if (!isset($value['amount']) || !isset($value['currency'])) {
            return;
        }
        $amount = (string) $value['amount'];
        $amount = str_replace(' ', '', $amount);
        $amount = $this->sfTransformer->reverseTransform($amount);
        $amount = round($amount);
        $amount = (int) $amount;

        return new Money($amount, $value['currency']);
    }
}
