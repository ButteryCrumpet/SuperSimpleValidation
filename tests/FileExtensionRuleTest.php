<?php

use PHPUnit\Framework\TestCase;
use SuperSimpleValidation\Rules\FileExtension;
use SuperSimpleValidation\ValidationException;
use Psr\Http\Message\UploadedFileInterface;

class FileExtensionRuleTest extends TestCase
{
    public function testInitializes()
    {
        $this->assertInstanceOf(
            FileExtension::class,
            new FileExtension("pdf", "error")
        );
    }

    public function testCorrectlyValidatesFileExtension()
    {
        $uploadFile = $this->createMock(UploadedFileInterface::class);
        $uploadFile
            ->method("getClientFilename")
            ->willReturn("test.pdf");

        $rule = new FileExtension("pdf", "error");
        $this->assertTrue($rule->validate($uploadFile), "Validates upload file interface");
        $this->assertTrue($rule->validate("test.pdf"), "Validates file name");
        $this->assertFalse($rule->validate(null), "Invalidates correctly");
    }

    public function testThrowsExceptionOnIncorrectExtensionArg()
    {
        $this->expectException(\InvalidArgumentException::class);
        new FileExtension([], "error");
    }

    public function testThrowsExceptionOnInvalidAssert()
    {
        $this->expectException(ValidationException::class);
        $rule = new FileExtension("pdf", "error");
        $rule->assert([]);
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
