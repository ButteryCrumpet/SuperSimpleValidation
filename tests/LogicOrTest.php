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

        $this->false = $this->createMock(RuleInterface::class);
        $this->false
            ->method("validate")
            ->willReturn(false);
    }

    public function testInitializes()
    {
        $this->assertInstanceOf(
            LogicOr::class,
            new LogicOr([$this->true])
        );
    }

    public function testValidatesCorrectly()
    {
        $land = new LogicOr([$this->false, $this->false]);
        $this->assertFalse(
            $land->validate("ha"),
            "False when none true"
        );

        $land = new LogicOr([$this->false, $this->true, $this->false]);
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

        $assertInvalid = $this->createMock(RuleInterface::class);
        $assertInvalid
            ->method("assert")
            ->willThrowException(new ValidationException("message"));

        $this->expectException(ValidationException::class);
        $land = new LogicOr([$assertValid, $assertInvalid]);
        $land->assert("ho");
    }
}