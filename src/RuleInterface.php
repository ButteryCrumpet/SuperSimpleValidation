<?php

namespace SuperSimpleValidation;

interface RuleInterface
{
    public function assert($data);

    public function validate($data);
}