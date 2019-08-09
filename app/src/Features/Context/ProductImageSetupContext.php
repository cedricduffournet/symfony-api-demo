<?php

namespace App\Features\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class ProductImageSetupContext implements Context, SnippetAcceptingContext
{
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @BeforeScenario
     */
    public function removeUploadFolder()
    {
        $projectDir = $this->kernel->getProjectDir();
        $uploadDir = $this->kernel->getContainer()->getParameter('upload_directory');
        $filesystem = new Filesystem();
        $filesystem->remove($projectDir.'/public'.$uploadDir);
    }
}
