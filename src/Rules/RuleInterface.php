<?php

namespace Hpd\Validatify\Rules;

interface RuleInterface
{
    public function validate($value, $parameters = null): bool;
}
