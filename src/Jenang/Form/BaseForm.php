<?php

namespace Jenang\Form;

use Jenang\Validator\ValidationError;
use Illuminate\Support\Arr;

class BaseForm {
    protected $fields = [];
    public $instance;

    public $cleaned_data = [];
    public $errors = [];

    public function __construct() {
        $args = func_get_args();
        $data = Arr::get($args, 0, []);
        $instance = Arr::get($args, 1);
        $context = Arr::get($args, 2, []);

        $this->data = $data;
        $this->instance = $instance;
        $this->context = $context;
        $this->setFields();
    }

    public function addError($field, $error_message) {
        if (Arr::has($this->errors, $field)) {
            array_push($this->errors[$field], $error_message);
        } else {
            $this->errors[$field] = [$error_message];
        }
    }
    
    public function getValue($field) {
        return Arr::get($this->data, $field);
    }

    public function getErrors($field) {
        return Arr::get($this->errors, $field, []);
    }

    public function isValid() {
        foreach($this->fields as $field => $validators) {
            if (!$this->instance || ($this->instance && Arr::has($this->data, $field))) { # TODO: DRY
                $has_error = false;
                foreach ($validators as $validator) {
                    try {
                        $validator->isValid($this->getValue($field), $this->instance);
                    } catch (ValidationError $ve) {
                        $this->addError($field, $ve->getMessage());
                        if (!$has_error) $has_error = true;
                    }
                }
                if (!$has_error) $this->cleaned_data[$field] = $this->getValue($field);
            }
        }
        
        return !$this->errors;
    }

    protected function setFields() {
        throw new \Exception("setFields method not implemented");
    }

    public function save() {
        throw new \Exception("save method not implemented");
    }
}