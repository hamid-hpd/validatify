<?php

namespace Hpd\Validatify\Rules;

class AlphaSpaceRule implements RuleInterface {
    public function validate($value, $parameters = null): bool {
        return  is_string($value) && preg_match('/^[\p{L}p{M}\ ]+$/u', $value);
    }
}