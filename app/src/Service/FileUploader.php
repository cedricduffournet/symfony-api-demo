<?php

namespace App\Service;

use App\Model\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FileUploader
{
    private $projectDir;

    private $targetDirectory;

    public function __construct($projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function upload(UploadedFile $uploadedFile): File
    {
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $target = $this->getFullTargetDirectory();
        $extension = $uploadedFile->guessExtension();
        $size = $uploadedFile->getSize();
        $mimeType = $uploadedFile->getMimeType();

        $i = 0;
        // not using uniqid as is is difficult to test
        $fileName = $safeFilename.'-'.$i.'.'.$extension;
        while (file_exists($target.'/'.$fileName)) {
            $i++;
            $fileName = $safeFilename.'-'.$i.'.'.$extension;
        }

        try {
            $uploadedFile->move($target, $fileName);
        } catch (FileException $e) {
            throw new BadRequestHttpException('Error during uploading file');
        }

        $file = new File(
            $fileName,
            $extension,
            $size,
            $target,
            $originalFilename,
            $mimeType
        );

        return $file;
    }

    public function setTargetDirectory(string $directory): void
    {
        $this->targetDirectory = $directory;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }

    private function getFullTargetDirectory(): string
    {
        return $this->projectDir.$this->targetDirectory;
    }
}
