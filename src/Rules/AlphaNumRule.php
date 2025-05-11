<?php

namespace Hpd\Validatify\Rules;

class AlphaNumRule implements RuleInterface {
 /*
 Validate that an attribute contains only alpha-numeric characters.
 */   
    public function validate($value, $parameters = null): bool {
        if (! is_string($value) && ! is_numeric($value)) {
            return false;
        }

        return preg_match('/^[\p{L}\p{N}]+$/u', $value);
    }
}