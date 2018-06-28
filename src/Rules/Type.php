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
     * @var string
     */
    private $errorMessage;

    /**
     * Type constructor.
     * @param $type
     * @param string $errorMessage
     */
    public function __construct($type, $errorMessage)
    {
        $this->type = $type;
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
        $type = gettype($data);

        if (!($type === "object")) {
            return $type === $this->type;
        }

        return get_class($data) === $this->type;
    }

    /**
     * @return array
     */
    public function getErrorMessages()
    {
        return [$this->errorMessage];
    }
}
