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
