<?php

namespace SuperSimpleValidation\Rules;

use SuperSimpleValidation\RuleInterface;
use SuperSimpleValidation\ValidationException;

/**
 * Class Type
 * @package SuperSimpleValidation\Rules
 */
class Type implements RuleInterface
{
    /**
     * @var
     */
    private $type;

    /**
     * Type constructor.
     * @param $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * @param $data
     * @return bool
     * @throws ValidationException
     */
    public function assert($data)
    {
        if (!$this->validate($data)) {
            throw new ValidationException(sprintf(
                    "Type %s is not equal to type %s",
                    gettype($data),
                    gettype($this->type)
                )
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
        $type = gettype($data);

        if (!($type === "object")) {
            return $type === $this->type;
        }

        return get_class($data) === $this->type;
    }

}