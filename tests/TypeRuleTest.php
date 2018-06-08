<?php

use PHPUnit\Framework\TestCase;
use SuperSimpleValidation\Rules\Type;
use SuperSimpleValidation\ValidationException;

class TypeRuleTest extends TestCase
{
    public function testInitiates()
    {
        $this->assertInstanceOf(
            Type::class,
            new Type(Type::class)
        );
    }

    public function testCorrectlyValidates()
    {
        $validator = new Type(Type::class);
        $this->assertTrue($validator->validate($validator), "Validates classes");
        $validator = new Type("string");
        $this->assertTrue($validator->validate("hi"), "Validates string");
        $validator = new Type("array");
        $this->assertTrue($validator->validate(["hi"]), "Validates arrays");
        $validator = new Type("integer");
        $this->assertTrue($validator->validate(4));
    }

    public function testCorrectlyInvalidates()
    {
        $validator = new Type("string");
        $this->assertEquals(false, $validator->validate($validator));
    }

    public function testThrowsExceptionOnAssert()
    {
        $this->expectException(ValidationException::class);
        $bl = new Type(Type::class);
        $bl->assert("ho");
    }
}