<?php

use PHPUnit\Framework\TestCase;
use SuperSimpleValidation\Rules\Filetype;

class FiletypeRuleTest extends TestCase
{
    public function testInitializes()
    {
        $this->assertInstanceOf(
            Filetype::class,
            new Filetype(["25", "50", "44", "46"])
        );
    }

    public function testCorrectlyValidatesUploadedFile()
    {
        // TODO: all the tests
    }
}