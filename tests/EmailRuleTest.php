<?php

use PHPUnit\Framework\TestCase;
use SuperSimpleValidation\Rules\Email;
use SuperSimpleValidation\ValidationException;

class EmailRuleTest extends TestCase
{
    public function testInitiates()
    {
        $this->assertInstanceOf(
            Email::class,
            new Email
        );
    }

    public function testValidatesCorrectly()
    {
        $v = new Email;
        $this->assertEquals(true, $v->validate("abc@email.com"));
    }

    public function testInvalidatesCorrectly()
    {
        $v = new Email;
        $this->assertEquals(false, $v->validate("hiho"));
    }

    public function testThrowsExceptionOnAssert()
    {
        $this->expectException(ValidationException::class);
        $bl = new Email(["ho"]);
        $bl->assert("ho");
    }
}