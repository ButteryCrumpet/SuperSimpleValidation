<?php

namespace SuperSimpleValidation;

interface ValidatorInterface
{
    public function assert($data);

    public function validate($data);
}