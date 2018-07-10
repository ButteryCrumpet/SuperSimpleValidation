<?php

use PHPUnit\Framework\TestCase;
use SuperSimpleValidation\Rules\Required;
use SuperSimpleValidation\ValidationException;

class RequiredRuleTest extends TestCase
{
    public function testInitializes()
    {
        $this->assertInstanceOf(
            Required::class,
            new Required("error")
        );
    }

    public function testValidatesCorrectly()
    {
        $bl = new Required("error");
        $this->assertTrue(
            $bl->validate("ha"),
            "True when not empty or null"
        );
        $this->assertFalse(
            $bl->validate(""),
            "False when empty"
        );
        $this->assertFalse(
            $bl->validate(null),
            "False when null"
        );

        $uploadedFile = $this->createMock(\Psr\Http\Message\UploadedFileInterface::class);
        $uploadedFile->method("getError")->willReturn(4);
        $this->assertFalse(
            $bl->validate($uploadedFile),
            "False when file upload error"
        );
    }

    /**
     * @expectedException ValidationException;
     */
    public function testThrowsExceptionOnAssert()
    {
        $this->expectException("SuperSimpleValidation\ValidationException");
        $bl = new Required("error");
        $bl->assert("");
    }
}