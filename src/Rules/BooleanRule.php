<?php
namespace Hpd\Validatify\Rules;

class BooleanRule implements RuleInterface {
    public function validate($value, $parameters = null): bool {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null;
    }
}