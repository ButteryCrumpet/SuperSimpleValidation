<?php

namespace SuperSimpleValidation\Rules;

use SuperSimpleValidation\RuleInterface;
use SuperSimpleValidation\ValidationException;

/**
 * Class Blacklist
 * @package SuperSimpleValidation\Rules
 */
class Blacklist implements RuleInterface
{
    /**
     * @var array
     */
    private $blacklist;
    /**
     * @var string
     */
    private $errorMessage;

    /**
     * Blacklist constructor.
     * @param array $blacklist
     * @param string $errorMessage
     */
    public function __construct(array $blacklist, $errorMessage)
    {
        $this->blacklist = $blacklist;
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
        return !in_array($data, $this->blacklist);
    }

    /**
     * @return array
     */
    public function getErrorMessages()
    {
        return [$this->errorMessage];
    }
}