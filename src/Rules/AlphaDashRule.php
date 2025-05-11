<?php

namespace Hpd\Validatify\Rules;

class AlphaDashRule implements RuleInterface {
/* 
Validate that an attribute contains only alpha-numeric characters, dashes, and underscores.
*/
    public function validate($value, $parameters = null): bool {
        return is_string($value) && preg_match('/^[\p{L}\p{M}\p{N}_-]+$/u', $value);
    }
}