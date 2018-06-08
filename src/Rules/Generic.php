<?php

namespace SuperSimpleValidation\Rules;

use SuperSimpleValidation\ValidatorInterface;
use SuperSimpleValidation\ValidationException;

/**
 * Class Generic
 * @package SuperSimpleValidation\Rules
 */
class Generic implements ValidatorInterface
{
    /**
     * @var
     */
    private $callable;
    /**
     * @var string
     */
    private $message;

    /**
     * Generic constructor.
     * @param $callable MUST return bool
     * @param string $message
     */
    public function __construct($callable, $message = "Invalid value")
    {
        if (!\method_exists($callable, '__invoke')) {
            throw new \InvalidArgumentException("Value callable must be a closure or invokable object");
        }

        $this->callable = $callable;
        $this->message = $message;
    }

    /**
     * @param $data
     * @return bool
     * @throws ValidationException
     */
    public function assert($data)
    {
        if (!$this->validate($data)) {
            throw new ValidationException($this->message);
        }
        return true;
    }

    /**
     * @param $data
     * @return bool
     */
    public function validate($data)
    {
        return call_user_func($this->callable, $data);
    }

}