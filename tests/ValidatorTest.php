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
            new Validator([])
        );
    }

    public function testValidatesCorrectly()
    {
        $rule = $this->createMock(RuleInterface::class);
        $rule->method("validate")->willReturn(true);
        $rule->method("getErrorMessages")->willReturn(["error"]);

        $validator = new Validator(["test" => $rule]);
        $this->assertTrue(
            $validator->validate("whatever"),
            "Validates properly"
        );
    }

    public function testInvalidatesCorrectly()
    {
        $rule = $this->createMock(RuleInterface::class);
        $rule->method("validate")->willReturn(false);
        $rule->method("getErrorMessages")->willReturn(["error"]);

        $validator = new Validator(["test" => $rule]);
        $this->assertFalse(
            $validator->validate("whatever"),
            "Invalidates properly"
        );
        $this->assertEquals(
            ["error"],
            $validator->getErrorMessages(),
            "Correctly retrieves errors"
        );
    }
}

