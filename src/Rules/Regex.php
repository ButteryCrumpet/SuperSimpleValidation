<?php

namespace SuperSimpleValidation\Rules;

use SuperSimpleValidation\RuleInterface;
use SuperSimpleValidation\ValidationException;

/**
 * Class Regex
 * @package SuperSimpleValidation\Rules
 */
class Regex implements RuleInterface
{
    /**
     * @var $regex
     */
    private $regex;
    /**
     * @var string
     */
    private $errorMessage;
    /**
     * Regex constructor.
     * @param string $regex must be valid regex
     * @param string $errorMessage
     */
    public function __construct($regex, $errorMessage)
    {
        $this->regex = $regex;
        $this->errorMessage = $errorMessage;
    }

    /**
     * @param $data
     * @return bool
     * @throws ValidationException
     */
    public function assert($data)
    {
        if (!preg_match($this->regex, $data)) {
            throw new ValidationException($this->errorMessage);
        }
        return true;
    }

    /**
     * @param $data
     * @return false|int
     */
    public function validate($data)
    {
        return preg_match($this->regex, $data);
    }

    /**
     * @return array
     */
    public function getErrorMessages()
    {
        return [$this->errorMessage];
    }
}