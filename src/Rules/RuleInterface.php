<?php

namespace SuperSimpleValidation\Rules;

interface RuleInterface
{
    public function assert($data);

    public function validate($data);
}