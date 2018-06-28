<?php

use PHPUnit\Framework\TestCase;
use SuperSimpleValidation\Rules\Blacklist;
use SuperSimpleValidation\ValidationException;

class BlacklistRuleTest extends TestCase
{
    public function testInitializes()
    {
        $this->assertInstanceOf(
            Blacklist::class,
            new Blacklist(["hi", "ho"], "error")
        );
    }

    public function testValidatesCorrectly()
    {
        $bl = new Blacklist(["hi", "ho"], "error");
        $this->assertTrue(
            $bl->validate("ha"),
            "True when value not in blacklist"
        );
        $this->assertFalse(
            $bl->validate("hi"),
            "False when value in blacklist"
        );
    }

    /**
     * @expectedException ValidationException;
     */
    public function testThrowsExceptionOnAssert()
    {
        $this->expectException(ValidationException::class);
        $bl = new Blacklist(["ho"], "error");
        $bl->assert("ho");
    }
}