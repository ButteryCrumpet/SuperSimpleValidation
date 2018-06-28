<?php

namespace SuperSimpleValidation\Logic;

use SuperSimpleValidation\ValidationException;
use SuperSimpleValidation\RuleInterface;

class LogicXor implements RuleInterface
{
    /**
     * @var RuleInterface[]
     */
    private $validators;
    /**
     * @var string
     */
    private $errorMessages;

    public function __construct(array $validators, $errorMessage)
    {
        $this->validators = $validators;
        $this->errorMessages[0] = $errorMessage;
    }

    public function assert($data)
    {
        if (!$this->validate($data)) {
            throw new ValidationException($this->errorMessages[0]);
        }
        return true;
    }

    public function validate($data)
    {
        $pass = false;
        foreach ($this->validators as $validator) {
            $pass = $pass ^ $validator->validate($data);
        }
        return (bool)$pass;
    }

    public function getErrorMessages()
    {
        return $this->errorMessages;
    }
}