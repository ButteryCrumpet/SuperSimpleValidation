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
            new Email("error")
        );
    }

    public function testValidatesCorrectly()
    {
        $v = new Email("error");
        $this->assertEquals(true, $v->validate("abc@email.com"));
    }

    public function testInvalidatesCorrectly()
    {
        $v = new Email("error");
        $this->assertEquals(false, $v->validate("hiho"));
    }

    public function testThrowsExceptionOnAssert()
    {
        $this->expectException(ValidationException::class);
        $bl = new Email("error");
        $bl->assert("ho");
    }
}