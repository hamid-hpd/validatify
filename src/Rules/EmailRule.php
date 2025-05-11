<?php
namespace Hpd\Validatify\Rules;

class EmailRule implements RuleInterface {
    public function validate($value, $parameters = null): bool {
    
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
}