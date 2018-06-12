<?php

namespace SuperSimpleValidation;

interface ValidatorInterface extends RuleInterface
{
    public function getErrors();
}