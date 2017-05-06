<?php

namespace Jenang\Validator;

use Illuminate\Support\Arr;
use Illuminate\Database\Capsule\Manager as Capsule;

class UniqueValidator extends BaseValidator {
    protected $message = "Please choose another %s";

    public function __construct() {
        # Args: field_name, db_table.db_field, message
        $args = func_get_args();
        $field_name = $args[0];
        $db_field_name = $args[1];
        $message = Arr::get($args, 2);

        parent::__construct($field_name, $message);
        $this->db_field_name = $db_field_name;
    }

    public function isValid() {
        $args = func_get_args();
        $value = $args[0];
        $instance = $args[1];
        $include_null = Arr::get($args, 2, false);
        $db_field_name = explode('.', $this->db_field_name);

        if (!$include_null && $value == null) return true;

        // not different compared to origin
        if ($instance && $instance->{$db_field_name[1]} == $value)
            return true;

        

        $exist = Capsule::table($db_field_name[0])->where($db_field_name[1], $value)->count();

        if ($exist > 0)
            $this->raiseValidationError();

        return true;
    }
}
