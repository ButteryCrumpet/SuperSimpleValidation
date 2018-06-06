<?php

namespace SuperSimpleValidation;

use SuperSimpleValidation\Rules\RuleInterface;

class Validator
{
    private $rules;
    private $messages;
    private $errors = [];


    /**
     * Validator constructor.
     * @param RuleInterface[] $rules
     * @param array $messages
     */
    public function __construct(array $rules, array $messages = [])
    {
        $this->rules = $rules;
        $this->messages = $messages;
    }

    public function validate($data)
    {
        foreach ($this->rules as $name => $rule) {
            if (!$rule->validate($data)) {
                $this->errors[] = isset($this->messages[$name])
                    ? $this->messages[$namee]
                    : sprintf("%s invalid for rule %s", $data, gettype($rule));
            }
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}

