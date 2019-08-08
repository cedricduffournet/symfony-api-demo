<?php

namespace App\Media;

use App\Entity\Media;
use App\Model\File;

class MediaFactory
{
    public function createFromFile(File $file): Media
    {
        return Media::create(
            $file->getName(),
            $file->getOriginalName(),
            $file->getExtension(),
            $file->getTargetDirectory(),
            $file->getSize(),
            $file->getMimeType()
        );
    }
}
