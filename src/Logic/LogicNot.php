<?php

namespace SuperSimpleValidation\Logic;

use SuperSimpleValidation\ValidationException;
use SuperSimpleValidation\ValidatorInterface;

class LogicNot implements ValidatorInterface
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
            try {
                $pass = $validator->assert($data);
            } catch (ValidationException $e) {
                $pass = false;
            }
            if ($pass) {
                throw new ValidationException("Validation failed");
            }
        }

        return !$pass;
    }

    public function validate($data)
    {
        $pass = true;
        foreach ($this->validators as $validator) {
            $pass = $pass && !$validator->validate($data);
        }

        return $pass;
    }

}