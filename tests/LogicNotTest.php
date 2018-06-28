<?php

use PHPUnit\Framework\TestCase;
use SuperSimpleValidation\Logic\LogicNot;
use SuperSimpleValidation\RuleInterface;
use SuperSimpleValidation\ValidationException;

class LogicNotTest extends TestCase
{
    private $true;
    private $false;

    public function setUp()
    {
        $this->true = $this->createMock(RuleInterface::class);
        $this->true
            ->method("validate")
            ->willReturn(true);
        $this->true
            ->method("getErrorMessages")
            ->willReturn(["error"]);

        $this->false = $this->createMock(RuleInterface::class);
        $this->false
            ->method("validate")
            ->willReturn(false);
        $this->false
            ->method("getErrorMessages")
            ->willReturn(["error"]);
    }

    public function testInitializes()
    {
        $this->assertInstanceOf(
            LogicNot::class,
            new LogicNot([$this->true], "error")
        );
    }

    public function testValidatesCorrectly()
    {
        $land = new LogicNot([$this->false, $this->true], "error");
        $this->assertFalse(
            $land->validate("ha"),
            "False when one true"
        );

        $land = new LogicNot([$this->false, $this->false, $this->false], "error");
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
        $assertValid = $this->createMock(RuleInterface::class);
        $assertValid
            ->method("assert")
            ->willReturn(true);

        $assertInvalid = $this->createMock(RuleInterface::class);
        $assertInvalid
            ->method("assert")
            ->willThrowException(new ValidationException("message"));

        $this->expectException(ValidationException::class);
        $land = new LogicNot([$assertValid, $assertInvalid], "error");
        $land->assert("ho");
    }
}