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
     * Whitelist constructor.
     * @param array $whitelist
     */
    public function __construct(array $whitelist)
    {
        $this->whitelist = $whitelist;
    }

    /**
     * @param $data
     * @return bool
     * @throws ValidationException
     */
    public function assert($data)
    {
        if (!$this->validate($data)) {
            throw new ValidationException(
                sprintf("%s is not a whitelisted value", $data)
            );
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

}