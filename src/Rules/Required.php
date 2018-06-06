<?php

namespace SuperSimpleValidation\Rules;

use SuperSimpleValidation\ValidationException;

/**
 * Class Required
 * @package SuperSimpleValidation\Rules
 */
class Required implements RuleInterface
{
    /**
     * @param $data
     * @throws ValidationException
     */
    public function assert($data)
    {
        if (!$this->validate($data)) {
            throw new ValidationException(
                "Required value is null or empty"
            );
        }
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
