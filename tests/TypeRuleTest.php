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
            new Type(Type::class, "error")
        );
    }

    public function testCorrectlyValidates()
    {
        $validator = new Type(Type::class, "error");
        $this->assertTrue($validator->validate($validator), "Validates classes");
        $validator = new Type("string", "error");
        $this->assertTrue($validator->validate("hi"), "Validates string");
        $validator = new Type("array", "error");
        $this->assertTrue($validator->validate(["hi"]), "Validates arrays");
        $validator = new Type("integer", "error");
        $this->assertTrue($validator->validate(4));
    }

    public function testCorrectlyInvalidates()
    {
        $validator = new Type("string", "error");
        $this->assertEquals(false, $validator->validate($validator));
    }

    public function testThrowsExceptionOnAssert()
    {
        $this->expectException(ValidationException::class);
        $bl = new Type(Type::class, "error");
        $bl->assert("ho");
    }
}