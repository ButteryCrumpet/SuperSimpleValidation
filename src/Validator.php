<?php

namespace SuperSimpleValidation;

/**
 * Class Validator
 * @package SuperSimpleValidation
 */
class Validator implements RuleInterface
{
    /**
     * @var RuleInterface[]
     */
    private $rules = [];
    /**
     * @var array
     */
    private $errorMessages = [];



    /**
     * Validator constructor.
     * @param RuleInterface[] $rules
     */
    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * @param $data
     * @return bool
     */
    public function validate($data)
    {
        $pass = true;
        foreach ($this->rules as $name => $rule) {
            if (!$rule->validate($data)) {
                foreach ($rule->getErrorMessages() as $message) {
                    $this->errorMessages[] = $message;
                }
                $pass = false;
            }
            $pass = $pass && true;
        }
        return $pass;
    }

    /**
     * @param $data
     * @return bool
     */
    public function assert($data)
    {
        foreach ($this->rules as $rule) {
            $rule->assert($data);
        }
        return true;
    }

    /**
     * @return array
     */
    public function getErrorMessages()
    {
        return $this->errorMessages;
    }
}

