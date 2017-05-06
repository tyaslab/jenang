<?php

namespace Jenang\Validator;

use Jenang\Validator\RegexValidator;

class DecimalValidator extends RegexValidator {
    protected $pattern = "/^[0-9]+(\.[0-9]+)?$/";
}