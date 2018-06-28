<?php

namespace SuperSimpleValidation\Rules;

use SuperSimpleValidation\RuleInterface;
use SuperSimpleValidation\ValidationException;

/**
 * Class Generic
 * @package SuperSimpleValidation\Rules
 */
class Generic implements RuleInterface
{
    /**
     * @var
     */
    private $callable;
    /**
     * @var string
     */
    private $errorMessage;

    /**
     * Generic constructor.
     * @param Callable $callable
     * @param string $errorMessage
     */
    public function __construct($callable, $errorMessage)
    {
        if (!\method_exists($callable, '__invoke')) {
            throw new \InvalidArgumentException("Value callable must be a closure or invokable object");
        }

        $this->callable = $callable;
        $this->errorMessage = $errorMessage;
    }

    /**
     * @param $data
     * @return bool
     * @throws ValidationException
     */
    public function assert($data)
    {
        if (!$this->validate($data)) {
            throw new ValidationException($this->errorMessage);
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

    /**
     * @return array
     */
    public function getErrorMessages()
    {
        return [$this->errorMessage];
    }

}