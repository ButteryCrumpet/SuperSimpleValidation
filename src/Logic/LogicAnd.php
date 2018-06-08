<?php

namespace SuperSimpleValidation\Logic;

use SuperSimpleValidation\ValidatorInterface;

class LogicAnd implements ValidatorInterface
{
    private $validators;

    public function __construct(array $validators)
    {
        $this->validators = $validators;
    }

    public function assert($data)
    {
        $pass = true;
        foreach ($this->validators as $validator) {
            $pass = $pass && $validator->assert($data);
        }

        return $pass;
    }

    public function validate($data)
    {
        $pass = true;
        foreach ($this->validators as $validator) {
            $pass = $pass && $validator->validate($data);
        }

        return $pass;
    }

}