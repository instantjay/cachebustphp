<?php

namespace App;

use Symfony\Component\HttpFoundation\File\File;

class ResourceSizeHashToken implements CacheBustTokenInterface
{
    protected $hash;

    /**
     * @param File $file
     * @return string
     * @throws \Exception Thrown if there appears to be something wrong with the file.
     */
    protected function calculateHash(File $file)
    {
        $fileSize = $file->getSize();

        if (!is_numeric($fileSize) || $fileSize <= 0) {
            throw new \Exception('File size is not a numeric or was smaller or equal to 0.');
        }

        return hash('sha256', $fileSize);
    }

    /**
     * @param File $file
     * @return string
     * @throws \Exception Thrown when the file is not a valid file.
     */
    public function getTokenString(File $file)
    {
        if (!$file->isFile()) {
            throw new \Exception('Provided file does not appear to be an actual file.');
        }

        return $this->calculateHash($file);
    }
}
