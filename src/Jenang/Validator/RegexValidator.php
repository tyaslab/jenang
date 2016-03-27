<?php

namespace Jenang\Validator;

class RegexValidator extends BaseValidator {
    protected $pattern;

    public function isValid() {
        $args = func_get_args();
        $value = $args[0];

        if ($value == null) return true;
        
        $matched = false;
        
        if ($value != null) {
            $matched = preg_match($this->pattern, $value);
        }

        if (!$matched) $this->raiseValidationError();

        return true;
    }
}

class NumberValidator extends RegexValidator {
    protected $pattern = "/^[0-9]+$/";
}

class DecimalValidator extends RegexValidator {
    protected $pattern = "/^[0-9]+(\.[0-9]+)?$/";
}

class EmailValidator extends RegexValidator {
    // From http://stackoverflow.com/questions/13447539/php-preg-match-with-email-validation-issue
    protected $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
}
