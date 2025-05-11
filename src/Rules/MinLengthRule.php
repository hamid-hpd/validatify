<?php

namespace Hpd\Validatify\Rules;

class MinLengthRule implements RuleInterface {
    public function validate($value, $parameters = null): bool {
      
            if (is_countable($value)){
                return count($value) >= $parameters[0];
            }
            if(is_string($value)) {
                return mb_strlen($value) >= $parameters[0];
            }
            if(is_numeric($value)){
                
                $length = mb_strlen((string) $value);
                return ! preg_match('/[^0-9]/', $value) && $length >= $parameters[0];
            }
            return false;
    }
}
