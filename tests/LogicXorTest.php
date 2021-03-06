<?php

use PHPUnit\Framework\TestCase;
use SuperSimpleValidation\Logic\LogicXor;
use SuperSimpleValidation\RuleInterface;
use SuperSimpleValidation\ValidationException;

class LogicXorTest extends TestCase
{
    private $true;
    private $false;

    public function setUp()
    {
        $this->true = $this->createMock(RuleInterface::class);
        $this->true
            ->method("validate")
            ->willReturn(true);

        $this->false = $this->createMock(RuleInterface::class);
        $this->false
            ->method("validate")
            ->willReturn(false);
    }

    public function testInitializes()
    {
        $this->assertInstanceOf(
            LogicXor::class,
            new LogicXor([$this->true], "error")
        );
    }

    public function testValidatesCorrectly()
    {
        $land = new LogicXor([$this->false, $this->false], "error");
        $this->assertFalse(
            $land->validate("ha"),
            "False when none true"
        );

        $land = new LogicXor([$this->false, $this->true, $this->false], "error");
        $this->assertTrue(
            $land->validate("hi"),
            "True when one true"
        );

        $land = new LogicXor([$this->false, $this->true, $this->true], "error");
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
        $assertValid = $this->createMock(RuleInterface::class);
        $assertValid
            ->method("assert")
            ->willReturn(true);

        $assertInvalid = $this->createMock(RuleInterface::class);
        $assertInvalid
            ->method("assert")
            ->willThrowException(new ValidationException("message"));

        $this->expectException(ValidationException::class);
        $land = new LogicXor([$assertValid, $assertInvalid], "error");
        $land->assert("ho");
    }
}