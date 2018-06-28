<?php

namespace SuperSimpleValidation\Logic;

use SuperSimpleValidation\RuleInterface;

/**
 * Class LogicAnd
 * @package SuperSimpleValidation\Logic
 */
class LogicAnd implements RuleInterface
{
    /**
     * @var RuleInterface[]
     */
    private $validators;
    /**
     * @var string
     */
    private $errorMessages;

    /**
     * LogicAnd constructor.
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
     */
    public function assert($data)
    {
        $pass = true;
        foreach ($this->validators as $validator) {
            $pass = $pass && $validator->assert($data);
        }

        return $pass;
    }

    /**
     * @param $data
     * @return bool
     */
    public function validate($data)
    {
        $pass = true;
        foreach ($this->validators as $validator) {
            if (!$validator->validate($data)) {
                foreach($validator->getErrorMessages() as $message) {
                    $this->errorMessages[] = $message;
                }
                $pass = false;
            }
        }

        return $pass;
    }

    /**
     * @return mixed
     */
    public function getErrorMessages()
    {
        return $this->errorMessages;
    }

}