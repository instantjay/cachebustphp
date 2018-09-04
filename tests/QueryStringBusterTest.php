<?php

namespace cachebustphp\Tests;

use instantjay\cachebustphp\Services\FileService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\File;
use Mockery;
use instantjay\cachebustphp\ResourceSizeHashToken;
use instantjay\cachebustphp\QueryStringBuster;

class QueryStringBusterTest extends TestCase
{
    protected $validFile;
    protected $fileService;
    protected $resourceSizeHashToken;

    public function setUp()
    {
        $file = Mockery::mock(File::class);
        $file->shouldReceive('isFile')->andReturn(true);
        $file->shouldReceive('getSize')->andReturn(10000);

        $this->validFile = $file;

        //
        $fileService = Mockery::mock(FileService::class);
        $fileService->shouldReceive('getFileByRelativePath')->andReturn($this->validFile);

        $this->fileService = $fileService;

        //
        $this->resourceSizeHashToken = new ResourceSizeHashToken();
    }

    public function testModifyResourcePath()
    {
        $queryStringBuster = new QueryStringBuster($this->resourceSizeHashToken, $this->fileService);

        $relativePath = 'random/path/image.jpg';

        $path = $queryStringBuster->modifyResourcePath($relativePath);

        //
        $containsRelativePath = mb_strpos($path, $relativePath) !== false;
        $this->assertTrue($containsRelativePath, 'Modified resource path did not contain the original relative path: '.$path);

        //
        $tokenized = explode('?', $path);
        $this->assertNotEmpty($tokenized[1], 'There does not appear to be any parameters in this path string.');

        //
        $queryParamString = $tokenized[1];
        $queryParams = [];
        parse_str($queryParamString, $queryParams);

        if(empty($queryParams[$queryStringBuster->getTokenParameterName()])) {
            $this->fail('There is no parameter with name ' . $queryStringBuster->getTokenParameterName());
        }

        $this->assertNotEmpty($queryParams[$queryStringBuster->getTokenParameterName()], 'There is no non-empty token parameter.');
    }

    public function testCustomParameterName()
    {
        $queryStringBuster = new QueryStringBuster($this->resourceSizeHashToken, $this->fileService);

        $customParameterName = 'custom_parameter';

        $queryStringBuster->setTokenParameterName($customParameterName);

        $path = $queryStringBuster->modifyResourcePath('random/path/image.jpg');

        $containsCustomParameter = mb_strpos($path, '?' . $customParameterName . '=') !== false;

        $this->assertTrue($containsCustomParameter, $path);
    }

    public function tearDown()
    {
        Mockery::close();
    }
}

