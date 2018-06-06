<?php

namespace SuperSimpleValidation\Rules;

use SuperSimpleValidation\ValidationException;

/**
 * Class Email
 * @package SuperSimpleValidation\Rules
 */
class Email implements RuleInterface
{
    /**
     * @param $data
     * @return bool
     * @throws ValidationException
     */
    public function assert($data)
    {
        if (!(is_string($input) && filter_var($data, FILTER_VALIDATE_EMAIL))) {
            throw new ValidationException(
                sprintf("%s is not a valid Email", $data)
            );
            return false;
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
}