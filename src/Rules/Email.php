<?php

namespace SuperSimpleValidation\Rules;

use SuperSimpleValidation\ValidatorInterface;
use SuperSimpleValidation\ValidationException;

/**
 * Class Email
 * @package SuperSimpleValidation\Rules
 */
class Email implements ValidatorInterface
{
    /**
     * @param $data
     * @return bool
     * @throws ValidationException
     */
    public function assert($data)
    {
        if (!(is_string($data) && filter_var($data, FILTER_VALIDATE_EMAIL))) {
            throw new ValidationException(
                sprintf("%s is not a valid Email", $data)
            );
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