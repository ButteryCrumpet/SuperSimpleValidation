<?php

namespace SuperSimpleValidation\Rules;

use SuperSimpleValidation\RuleInterface;
use SuperSimpleValidation\ValidationException;

/**
 * Class Required
 * @package SuperSimpleValidation\Rules
 */
class Required implements RuleInterface
{
    /**
     * @var string
     */
    private $errorMessage;

    /**
     * Required constructor.
     * @param string $errorMessage
     */
    public function __construct($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @param $data
     * @throws ValidationException
     * @return bool
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
        return !(is_null($data) || empty($data));
    }

    /**
     * @return array
     */
    public function getErrorMessages()
    {
        return [$this->errorMessage];
    }
}
