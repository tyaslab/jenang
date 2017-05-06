<?php

namespace Jenang\Validator;

class RequiredValidator extends BaseValidator {
    protected $message = "Field %s is required";

    public function isValid() {
        $args = func_get_args();
        $value = $args[0];

        if ($value == null) $this->raiseValidationError();

        return true;
    }
}
