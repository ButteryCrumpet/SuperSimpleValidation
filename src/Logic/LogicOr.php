<?php

namespace SuperSimpleValidation\Logic;

use SuperSimpleValidation\ValidationException;
use SuperSimpleValidation\ValidatorInterface;

class LogicOr implements ValidatorInterface
{
    private $validators;

    public function __construct(array $validators)
    {
        $this->validators = $validators;
    }

    public function assert($data)
    {
        if (!$this->validate($data)) {
            throw new ValidationException(
                "Validation failed"
            );
        }
        return true;
    }

    public function validate($data)
    {
        $pass = false;
        foreach ($this->validators as $validator) {
            $pass = $pass || $validator->validate($data);
        }
        return $pass;
    }

}