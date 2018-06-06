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
            new Blacklist(["hi", "ho"])
        );
    }

    public function testValidatesCorrectly()
    {
        $bl = new Blacklist(["hi", "ho"]);
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
        $this->expectException("SuperSimpleValidation\ValidationException");
        $bl = new Blacklist(["ho"]);
        $bl->assert("ho");
    }
}