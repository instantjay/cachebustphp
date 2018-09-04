<?php

namespace cachebustphp;

use cachebustphp\Services\FileService;

/**
 * Appends a query string to the resource URI with a cache busting token in it.
 *
 * Class QueryStringBuster
 * @package App
 */
class QueryStringBuster extends AbstractCacheBuster
{
    protected $tokenParameterName;

    /**
     * QueryStringBuster constructor.
     * @param CacheBustTokenInterface $token
     * @param FileService $fileService
     */
    public function __construct(CacheBustTokenInterface $token, FileService $fileService)
    {
        $this->tokenParameterName = 'token';

        parent::__construct($token, $fileService);
    }

    /**
     * Set a custom cache busting token parameter name. By default the token will simply be called "token".
     *
     * @param $parameterName
     */
    public function setTokenParameterName($parameterName)
    {
        $this->tokenParameterName = $parameterName;
    }

    /**
     * @return string
     */
    public function getTokenParameterName()
    {
        return $this->tokenParameterName;
    }

    /**
     * @param string $relativePath
     * @return string
     */
    public function modifyResourcePath($relativePath)
    {
        $file = $this->fileService->getFileByRelativePath($relativePath);

        $tokenString = $this->token->getTokenString($file);

        return $relativePath . '?' . $this->tokenParameterName . '=' . $tokenString;
    }
}
