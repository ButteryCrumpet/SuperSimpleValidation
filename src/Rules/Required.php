<?php

namespace SuperSimpleValidation\Rules;

use SuperSimpleValidation\ValidatorInterface;
use SuperSimpleValidation\ValidationException;

/**
 * Class Required
 * @package SuperSimpleValidation\Rules
 */
class Required implements ValidatorInterface
{
    /**
     * @param $data
     * @throws ValidationException
     * @return bool
     */
    public function assert($data)
    {
        if (!$this->validate($data)) {
            throw new ValidationException(
                "Required value is null or empty"
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
        return !(is_null($data) || empty($data));
    }
}
