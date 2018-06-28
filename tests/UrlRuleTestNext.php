<?php

use PHPUnit\Framework\TestCase;
use SuperSimpleValidation\Presets\Url;

class UrlRuleTest extends TestCase
{
    public function testInitiates()
    {
        $this->assertInstanceOf(
            Url::class,
            new Url("error")
        );
    }

    public function testValidatesCorrectly()
    {
        $v = new Url("error");
        $this->assertEquals(true, $v->validate("www.hiho.com"));
    }

    public function testInvalidatesCorrectly()
    {
        $v = new Url("error");
        $this->assertEquals(false, $v->validate("hur."));
    }
}