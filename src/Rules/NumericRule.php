<?php
namespace Hpd\Validatify\Rules;

class NumericRule implements RuleInterface {
    public function validate($value, $parameters = null): bool {
        return is_numeric($value);
    }
}