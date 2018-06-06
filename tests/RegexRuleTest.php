<?php

use PHPUnit\Framework\TestCase;
use SuperSimpleValidation\Rules\Regex;

class RegexRuleTest extends TestCase
{
    public function testInitiates()
    {
        $this->assertInstanceOf(
              Regex::class,
              new Regex('/^\(?\+?\d{1,4}\)?-?\d{2,4}-?\d{4}$/')
        );
    }

    public function testCorrectlyValidates()
    {
        $validator = new Regex('/^\(?\+?\d{1,4}\)?-?\d{2,4}-?\d{4}$/');
        $this->assertEquals(true, $validator->validate("080-5562-7260"));
    }

    public function testCorrectlyInvalidates()
    {
        $validator = new Regex('/^\(?\+?\d{1,4}\)?-?\d{2,4}-?\d{4}$/');
        $this->assertEquals(false, $validator->validate("080-55627260-"));
    }
}