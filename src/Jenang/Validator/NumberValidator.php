<?php

namespace Jenang\Validator;

use Jenang\Validator\RegexValidator;

class NumberValidator extends RegexValidator {
    protected $pattern = "/^[0-9]+$/";
}