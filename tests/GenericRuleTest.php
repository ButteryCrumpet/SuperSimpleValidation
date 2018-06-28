<?php

use PHPUnit\Framework\TestCase;
use SuperSimpleValidation\Rules\Generic;
use SuperSimpleValidation\ValidationException;

class GenericRuleTest extends TestCase
{
    public function testInitializes()
    {
        $this->assertInstanceOf(
            Generic::class,
            new Generic(function ($data) { return true; }, "error")
        );
    }

    public function testValidatesCorrectly()
    {
        $bl = new Generic(function ($data) {
            return $data === "ha";
        }, "error");
        $this->assertTrue(
            $bl->validate("ha"),
            "True"
        );
        $this->assertFalse(
            $bl->validate("hi"),
            "False"
        );
    }

    /**
     * @expectedException ValidationException;
     */
    public function testThrowsExceptionOnAssert()
    {
        $this->expectException(ValidationException::class);
        $bl = new Generic(function ($data) { return false; }, "error");
        $bl->assert("ho");
    }
}