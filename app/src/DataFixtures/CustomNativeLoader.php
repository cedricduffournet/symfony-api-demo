<?php

namespace App\DataFixtures;

use App\DataFixtures\Faker\Provider\CustomProvider;
use Faker\Factory as FakerGeneratorFactory;
use Faker\Generator as FakerGenerator;
use Nelmio\Alice\Faker\Provider\AliceProvider;
use Nelmio\Alice\Loader\NativeLoader;

class CustomNativeLoader extends NativeLoader
{
    protected function createFakerGenerator(): FakerGenerator
    {
        $generator = FakerGeneratorFactory::create(parent::LOCALE);
        $generator->addProvider(new AliceProvider());
        $generator->addProvider(new CustomProvider());
        $generator->seed($this->getSeed());

        return $generator;
    }
}
