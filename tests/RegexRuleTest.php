<?php

use PHPUnit\Framework\TestCase;
use SuperSimpleValidation\Rules\Regex;
use SuperSimpleValidation\ValidationException;

class RegexRuleTest extends TestCase
{
    public function testInitiates()
    {
        $this->assertInstanceOf(
              Regex::class,
              new Regex('/^\(?\+?\d{1,4}\)?-?\d{2,4}-?\d{4}$/', "error")
        );
    }

    public function testCorrectlyValidates()
    {
        $validator = new Regex('/^\(?\+?\d{1,4}\)?-?\d{2,4}-?\d{4}$/', "error");
        $this->assertEquals(true, $validator->validate("080-5562-7260"));
    }

    public function testCorrectlyInvalidates()
    {
        $validator = new Regex('/^\(?\+?\d{1,4}\)?-?\d{2,4}-?\d{4}$/', "error");
        $this->assertEquals(false, $validator->validate("080-55627260-"));
    }

    public function testThrowsExceptionOnAssert()
    {
        $this->expectException(ValidationException::class);
        $bl = new Regex('/^\(?\+?\d{1,4}\)?-?\d{2,4}-?\d{4}$/', "error");
        $bl->assert("d");
    }
}