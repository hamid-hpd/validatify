<?php

namespace Hpd\Validatify\Rules;

class AlphaRule implements RuleInterface {
    public function validate($value, $parameters = null): bool {
        return is_string($value) && preg_match('/^[\p{L}\p{M}]+$/u', $value);
    }
}