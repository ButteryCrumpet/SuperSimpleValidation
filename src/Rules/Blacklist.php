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
     * Blacklist constructor.
     * @param array $blacklist
     */
    public function __construct(array $blacklist)
    {
        $this->blacklist = $blacklist;
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
                sprintf("%s is a blacklisted value", $data)
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
        return !in_array($data, $this->blacklist);
    }

}