<?php

use PHPUnit\Framework\TestCase;
use SuperSimpleValidation\Rules\Whitelist;
use SuperSimpleValidation\ValidationException;

class WhitelistRuleTest extends TestCase
{
    public function testInitializes()
    {
        $this->assertInstanceOf(
            Whitelist::class,
            new Whitelist(["hi", "ho"])
        );
    }

    public function testValidatesCorrectly()
    {
        $wl = new Whitelist(["hi", "ho"]);
        $this->assertTrue(
            $wl->validate("hi"),
            "True when value not in whitelist"
        );
        $this->assertFalse(
            $wl->validate("ha"),
            "False when value in whitelist"
        );
    }

    /**
     * @expectedException ValidationException;
     */
    public function testThrowsExceptionOnAssert()
    {
        $this->expectException("SuperSimpleValidation\ValidationException");
        $wl = new Whitelist(["hi"]);
        $wl->assert("ho");
    }
}