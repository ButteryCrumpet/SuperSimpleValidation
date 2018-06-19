<?php

use PHPUnit\Framework\TestCase;
use SuperSimpleValidation\Rules\FileSignature;
use SuperSimpleValidation\ValidationException;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;

class FileSignatureRuleTest extends TestCase
{
    public function testInitializes()
    {
        $this->assertInstanceOf(
            FileSignature::class,
            new FileSignature(["25", "50", "44", "46"])
        );
    }

    public function testCorrectlyValidatesUploadedFile()
    {
        $resource = fopen('php://temp', "r+");
        fwrite($resource, "%PDF");
        fseek($resource, 0);

        $stream = $this->createMock(StreamInterface::class);
        $stream
            ->method("rewind");
        $stream
            ->method("read")
            ->willReturn(fread($resource, 4));
        $stream
            ->method("isReadable")
            ->willReturn(true);
        $stream
            ->method(("isSeekable"))
            ->willReturn(true);

        $uploaded = $this->createMock(UploadedFileInterface::class);
        $uploaded
            ->method("getStream")
            ->willReturn($stream);

        $fileTest = new FileSignature(["25", "50", "44", "46"]);
        $this->assertTrue($fileTest->validate($resource), "Validates resource");
        $this->assertTrue($fileTest->validate($stream), "Validates stream");
        $this->assertTrue($fileTest->validate($uploaded), "Validates uploaded file");
        $this->assertTrue($fileTest->validate("test.pdf"), "Validates file");
    }

    public function testCorrectlyHandlesOpeningStreamException()
    {
        $uploaded = $this->createMock(UploadedFileInterface::class);
        $uploaded
            ->method("getStream")
            ->willThrowException(new \RuntimeException());

        $fileTest = new FileSignature(["25", "50", "44", "46"]);
        $this->assertFalse($fileTest->validate($uploaded));
    }

    public function testThrowsExceptionOnAssert()
    {
        $this->expectException(ValidationException::class);
        $bl = new FileSignature(["28", "50", "44", "46"]);
        $bl->assert("test.pdf");
    }

    public function setUp()
    {
        parent::setUp();
        file_put_contents("test.pdf", "%PDF");
    }

    public function tearDown()/* The :void return type declaration that should be here would cause a BC issue */
    {
        unlink("test.pdf");
        parent::tearDown();
    }
}