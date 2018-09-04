<?php

namespace cachebustphp;

use cachebustphp\Services\FileService;

interface CacheBusterInterface
{
    public function __construct(CacheBustTokenInterface $token, FileService $fileService);
    public function modifyResourcePath($string);
}
