<?php

namespace cachebustphp\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\File;
use cachebustphp\ResourceSizeHashToken;

class ResourceSizeHashTest extends TestCase {
    protected $validFile;
    protected $invalidFile;

    public function setUp()
    {
        //
        $file = \Mockery::mock(File::class);
        $file->shouldReceive('isFile')->andReturnTrue();
        $file->shouldReceive('getSize')->andReturn(10000);

        $this->validFile = $file;

        //
        $invalidFile = \Mockery::mock(File::class);
        $invalidFile->shouldReceive('isFile')->andReturnFalse();
        $invalidFile->shouldReceive('getSize')->andReturn(0);

        $this->invalidFile = $invalidFile;
    }

    public function testGetTokenString() {
        $token = new ResourceSizeHashToken();

        $tokenString = $token->getTokenString($this->validFile);

        $this->assertNotEmpty($tokenString);
    }

    public function testGetTokenStringFailure() {
        $token = new ResourceSizeHashToken();

        $this->expectException(\Exception::class);

        $token->getTokenString($this->invalidFile);
    }

    public function tearDown()
    {
        \Mockery::close();
    }
}