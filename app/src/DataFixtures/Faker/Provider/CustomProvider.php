<?php

namespace App\DataFixtures\Faker\Provider;

use Faker\Factory;
use Money\Currency;
use Money\Money;

class CustomProvider
{
    public static function money($maxAmount = 0, $currency = 'EUR'): Money
    {
        $faker = Factory::create();

        $money = new Money($faker->numberBetween(10, $maxAmount), new Currency($currency));

        return $money;
    }
}
