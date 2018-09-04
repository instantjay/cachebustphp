<?php

namespace instantjay\cachebustphp;

use instantjay\cachebustphp\Services\FileService;

interface CacheBusterInterface
{
    public function __construct(CacheBustTokenInterface $token, FileService $fileService);
    public function modifyResourcePath($string);
}
