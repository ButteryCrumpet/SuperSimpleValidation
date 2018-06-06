<?php

namespace SuperSimpleValidation\Rules;

use SuperSimpleValidation\ValidationException;

class Regex implements RuleInterface
{
    /**
     * @var $regex
     */
    private $regex;

    /**
     * Regex constructor.
     * @param string $regex must be valid regex
     */
    public function __construct($regex)
    {
        $this->regex = $regex;
    }

    /**
     * @param $data
     * @return bool
     * @throws ValidationException
     */
    public function assert($data)
    {
        if (!preg_match($this->regex, $data)) {
            throw new ValidationException(sprintf(
                "%s does not match regex %s", $data, $this->regex
            ));
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
}