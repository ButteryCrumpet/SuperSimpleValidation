<?php

use PHPUnit\Framework\TestCase;
use SuperSimpleValidation\Presets\Url;

class UrlRuleTest extends TestCase
{
    public function testInitiates()
    {
        $this->assertInstanceOf(
            Url::class,
            new Url
        );
    }

    public function testValidatesCorrectly()
    {
        $v = new Url;
        $this->assertEquals(true, $v->validate("www.hiho.com"));
    }

    public function testInvalidatesCorrectly()
    {
        $v = new Url;
        $this->assertEquals(false, $v->validate("hur."));
    }
}