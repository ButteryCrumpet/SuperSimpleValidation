<?php

namespace SuperSimpleValidation\Rules;

use SuperSimpleValidation\RuleInterface;
use SuperSimpleValidation\ValidationException;

/**
 * Class Email
 * @package SuperSimpleValidation\Rules
 */
class Email implements RuleInterface
{
    /**
     * @var string
     */
    private $errorMessage;

    /**
     * Email constructor.
     * @param string $errorMessage
     */
    public function __construct($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @param $data
     * @return bool
     * @throws ValidationException
     */
    public function assert($data)
    {
        if (!(is_string($data) && filter_var($data, FILTER_VALIDATE_EMAIL))) {
            throw new ValidationException($this->errorMessage);
        }
        return true;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function validate($data)
    {
        return is_string($data) && filter_var($data, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @return array
     */
    public function getErrorMessages()
    {
        return [$this->errorMessage];
    }
}