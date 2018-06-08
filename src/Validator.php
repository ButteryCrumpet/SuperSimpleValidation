<?php

namespace SuperSimpleValidation;

class Validator implements ValidatorInterface
{
    private $rules;
    private $messages;
    private $errors = [];


    /**
     * Validator constructor.
     * @param ValidatorInterface[] $rules
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
                    ? $this->messages[$name]
                    : sprintf("%s invalid for rule %s", $data, get_class($rule));
            }
        }
    }

    public function assert($data)
    {
        foreach ($this->rules as $name => $rule) {
            $rule->assert($data);
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}

