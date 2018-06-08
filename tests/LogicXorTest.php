<?php

use PHPUnit\Framework\TestCase;
use SuperSimpleValidation\Logic\LogicXor;
use SuperSimpleValidation\ValidatorInterface;
use SuperSimpleValidation\ValidationException;

class LogicXorTest extends TestCase
{
    private $true;
    private $false;

    public function setUp()
    {
        $this->true = $this->createMock(ValidatorInterface::class);
        $this->true
            ->method("validate")
            ->willReturn(true);

        $this->false = $this->createMock(ValidatorInterface::class);
        $this->false
            ->method("validate")
            ->willReturn(false);
    }

    public function testInitializes()
    {
        $this->assertInstanceOf(
            LogicXor::class,
            new LogicXor([$this->true])
        );
    }

    public function testValidatesCorrectly()
    {
        $land = new LogicXor([$this->false, $this->false]);
        $this->assertFalse(
            $land->validate("ha"),
            "False when none true"
        );

        $land = new LogicXor([$this->false, $this->true, $this->false]);
        $this->assertTrue(
            $land->validate("hi"),
            "True when one true"
        );

        $land = new LogicXor([$this->false, $this->true, $this->true]);
        $this->assertFalse(
            $land->validate("hi"),
            "False when more than one true"
        );
    }

    /**
     * @expectedException ValidationException;
     */
    public function testThrowsExceptionOnAssert()
    {
        $assertValid = $this->createMock(ValidatorInterface::class);
        $assertValid
            ->method("assert")
            ->willReturn(true);

        $assertInvalid = $this->createMock(ValidatorInterface::class);
        $assertInvalid
            ->method("assert")
            ->willThrowException(new ValidationException("message"));

        $this->expectException(ValidationException::class);
        $land = new LogicXor([$assertValid, $assertInvalid]);
        $land->assert("ho");
    }
}