<?php

namespace Hpd\Validatify\Rules;

class ArrayRule implements RuleInterface {
    public function validate($value, $parameters = null): bool {
        
        return is_array($value);
    }
}