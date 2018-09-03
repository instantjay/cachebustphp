<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\File;

class FileService
{
    protected $basePath;

    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @param string $relativePath
     * @return File
     */
    public function getFileByRelativePath($relativePath)
    {
        return new File($this->basePath . $relativePath);
    }

    /**
     * @param string $absolutePath
     * @return File
     */
    public function getFileByAbsolutePath($absolutePath)
    {
        return new File($absolutePath);
    }
}
