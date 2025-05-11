<?php

namespace Hpd\Validatify\Rules;

class StringRule implements RuleInterface {
    public function validate($value, $parameters = null): bool {
        return is_string($value);
    }
}