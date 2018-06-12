<?php

namespace SuperSimpleValidation;

/**
 * Class Validator
 * @package SuperSimpleValidation
 */
class Validator implements ValidatorInterface
{
    /**
     * @var array|RuleInterface[]
     */
    private $rules;
    /**
     * @var array
     */
    private $messages;
    /**
     * @var array
     */
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

    /**
     * @param $data
     * @return bool
     */
    public function validate($data)
    {
        $pass = true;
        foreach ($this->rules as $name => $rule) {
            if (!$rule->validate($data)) {
                $this->errors[$name] = isset($this->messages[$name])
                    ? $this->messages[$name]
                    : sprintf(
                        "%s invalid for rule %s",
                        var_export($data, true),
                        get_class($rule)
                    );
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
    public function getErrors()
    {
        return $this->errors;
    }
}

