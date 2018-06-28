<?php

namespace SuperSimpleValidation\Logic;

use SuperSimpleValidation\ValidationException;
use SuperSimpleValidation\RuleInterface;

/**
 * Class LogicOr
 * @package SuperSimpleValidation\Logic
 */
class LogicOr implements RuleInterface
{
    /**
 * @var RuleInterface[]
 */
    private $validators;
    /**
     * @var string[]
     */
    private $errorMessages;

    /**
     * LogicOr constructor.
     * @param array $validators
     * @param string $errorMessage
     */
    public function __construct(array $validators, $errorMessage)
    {
        $this->validators = $validators;
        $this->errorMessages[] = $errorMessage;
    }

    /**
     * @param $data
     * @return bool
     * @throws ValidationException
     */
    public function assert($data)
    {
        if (!$this->validate($data)) {
            throw new ValidationException($this->errorMessages[0]);
        }
        return true;
    }

    /**
     * @param $data
     * @return bool
     */
    public function validate($data)
    {
        $pass = false;
        foreach ($this->validators as $validator) {
            $result = $validator->validate($data);
            if (!$result) {
                foreach($validator->getErrorMessages() as $message) {
                    $this->errorMessages[] = $message;
                }
            }
            $pass = $pass || $result;
        }
        return $pass;
    }

    /**
     * @return string
     */
    public function getErrorMessages()
    {
        return $this->errorMessages;
    }

}