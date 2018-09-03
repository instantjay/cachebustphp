<?php

namespace App;

use App\Services\FileService;

abstract class AbstractCacheBuster implements CacheBusterInterface
{
    protected $token;
    protected $fileService;

    public function __construct(CacheBustTokenInterface $token, FileService $fileService)
    {
        $this->token = $token;
        $this->fileService = $fileService;
    }
}
