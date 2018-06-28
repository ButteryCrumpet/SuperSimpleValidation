<?php

use PHPUnit\Framework\TestCase;
use SuperSimpleValidation\Logic\LogicAnd;
use SuperSimpleValidation\RuleInterface;
use SuperSimpleValidation\ValidationException;

class LogicAndTest extends TestCase
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
            LogicAnd::class,
            new LogicAnd([$this->true], "error")
        );
    }

    public function testValidatesCorrectly()
    {
        $land = new LogicAnd([$this->true, $this->true], "error");
        $this->assertTrue(
            $land->validate("ha"),
            "True when all true"
        );

        $land = new LogicAnd([$this->true, $this->false, $this->true], "error");
        $this->assertFalse(
            $land->validate("hi"),
            "False when one false"
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
        $land = new LogicAnd([$assertValid, $assertInvalid], "error");
        $land->assert("ho");
    }
}