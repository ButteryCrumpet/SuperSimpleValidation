<?php

use PHPUnit\Framework\TestCase;
use SuperSimpleValidation\Logic\LogicNot;
use SuperSimpleValidation\ValidatorInterface;
use SuperSimpleValidation\ValidationException;

class LogicNotTest extends TestCase
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
            LogicNot::class,
            new LogicNot([$this->true])
        );
    }

    public function testValidatesCorrectly()
    {
        $land = new LogicNot([$this->false, $this->true]);
        $this->assertFalse(
            $land->validate("ha"),
            "False when one true"
        );

        $land = new LogicNot([$this->false, $this->false, $this->false]);
        $this->assertTrue(
            $land->validate("hi"),
            "True when all false"
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
        $land = new LogicNot([$assertValid, $assertInvalid]);
        $land->assert("ho");
    }
}