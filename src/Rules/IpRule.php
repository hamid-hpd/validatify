<?php

namespace Hpd\Validatify\Rules;

class IpRule implements RuleInterface {
    public function validate($value, $parameters = null): bool {
        return filter_var($value, FILTER_VALIDATE_IP) !== false;
    }
}