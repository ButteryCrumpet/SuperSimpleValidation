<?php

use PHPUnit\Framework\TestCase;
use SuperSimpleValidation\Logic\LogicOr;
use SuperSimpleValidation\RuleInterface;
use SuperSimpleValidation\ValidationException;

class LogicOrTest extends TestCase
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
            LogicOr::class,
            new LogicOr([$this->true], "error")
        );
    }

    public function testValidatesCorrectly()
    {
        $land = new LogicOr([$this->false, $this->false], "error");
        $this->assertFalse(
            $land->validate("ha"),
            "False when none true"
        );

        $land = new LogicOr([$this->false, $this->true, $this->false], "error");
        $this->assertTrue(
            $land->validate("hi"),
            "True when one true"
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
        $assertValid
            ->method("getErrorMessages")
            ->willReturn(["error"]);

        $assertInvalid = $this->createMock(RuleInterface::class);
        $assertInvalid
            ->method("assert")
            ->willThrowException(new ValidationException("message"));
        $assertInvalid
            ->method("getErrorMessages")
            ->willReturn(["error"]);

        $this->expectException(ValidationException::class);
        $land = new LogicOr([$assertValid, $assertInvalid], "error");
        $land->assert("ho");
    }
}