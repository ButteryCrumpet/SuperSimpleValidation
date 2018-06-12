<?php

use PHPUnit\Framework\TestCase;
use SuperSimpleValidation\Validator;
use SuperSimpleValidation\RuleInterface;

class ValidatorTest extends TestCase
{
    public function testInitializes()
    {
        $this->assertInstanceOf(
            Validator::class,
            new Validator([],[])
        );
    }

    public function testValidatesCorrectly()
    {
        $rule = $this->createMock(RuleInterface::class);
        $rule->method("validate")->willReturn(true);

        $validator = new Validator(["test" => $rule], ["test" => "error"]);
        $this->assertTrue(
            $validator->validate("whatever"),
            "Validates properly"
        );
    }

    public function testInvalidatesCorrectly()
    {
        $rule = $this->createMock(RuleInterface::class);
        $rule->method("validate")->willReturn(false);

        $validator = new Validator(["test" => $rule], ["test" => "error"]);
        $this->assertFalse(
            $validator->validate("whatever"),
            "Invalidates properly"
        );
        $this->assertEquals(
            ["test" => "error"],
            $validator->getErrors(),
            "Correctly retrieves errors"
        );
    }
}

