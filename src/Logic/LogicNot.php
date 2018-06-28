<?php

namespace SuperSimpleValidation\Logic;

use SuperSimpleValidation\ValidationException;
use SuperSimpleValidation\RuleInterface;

/**
 * Class LogicNot
 * @package SuperSimpleValidation\Logic
 */
class LogicNot implements RuleInterface
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
     * LogicNot constructor.
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
        $pass = true;
        foreach ($this->validators as $validator) {
            try {
                $pass = $validator->assert($data);
            } catch (ValidationException $e) {
                $pass = false;
            }
            if ($pass) {
                throw new ValidationException($this->errorMessages[0]);
            }
        }

        return !$pass;
    }

    /**
     * @param $data
     * @return bool
     */
    public function validate($data)
    {
        $pass = true;
        foreach ($this->validators as $validator) {
            if ($validator->validate($data)) {
                foreach($validator->getErrorMessages() as $message) {
                    $this->errorMessages[] = $message;
                }
                $pass = false;
            }
        }

        return $pass;
    }

    /**
     * @return string[]
     */
    public function getErrorMessages()
    {
        return $this->errorMessages;
    }

}