<?php

namespace instantjay\cachebustphp;

use Symfony\Component\HttpFoundation\File\File;

interface CacheBustTokenInterface
{
    /**
     * @param File $file
     * @return string
     */
    public function getTokenString(File $file);
}
