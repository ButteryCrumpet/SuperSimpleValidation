<?php

namespace SuperSimpleValidation\Rules;

use SuperSimpleValidation\RuleInterface;
use SuperSimpleValidation\ValidationException;

/**
 * Class Whitelist
 * @package SuperSimpleValidation\Rules
 */
class Whitelist implements RuleInterface
{
    /**
     * @var array
     */
    private $whitelist;
    /**
     * @var string
     */
    private $errorMessage;

    /**
     * Whitelist constructor.
     * @param array $whitelist
     * @param string $errorMessage
     */
    public function __construct(array $whitelist, $errorMessage)
    {
        $this->whitelist = $whitelist;
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
        return in_array($data, $this->whitelist);
    }

    /**
     * @return array
     */
    public function getErrorMessages()
    {
        return [$this->errorMessage];
    }

}