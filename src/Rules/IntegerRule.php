<?php

namespace Hpd\Validatify\Rules;

class IntegerRule implements RuleInterface {
    public function validate($value, $parameters = null): bool {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }
}