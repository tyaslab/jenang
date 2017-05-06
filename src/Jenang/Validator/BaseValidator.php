<?php

namespace Jenang\Validator;

use Illuminate\Support\Arr;

class ValidationError extends \Exception {}

class BaseValidator {
    protected $field_name;
    protected $message = "Invalid input for field %s";

    public function __construct($field_name, $message=null) {
        $args = func_get_args();
        $field_name = $args[0];
        $message = Arr::get($args, 1);

        $this->field_name = $field_name;
        if ($message) $this->message = $message;
    }

    public function isValid() {
        throw new \Exception("Method isValid() not implemented");
    }

    protected function raiseValidationError() {
        throw new ValidationError(sprintf($this->message, $this->field_name));
    }
}
