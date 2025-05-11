<?php

namespace Hpd\Validatify\Rules;

class AfterRule implements RuleInterface {
    public function validate($value, $parameters = null): bool {
        $date=new dateRule();
        $date1=$date->validate($value);
        $date2=$date->validate($parameters[0]);
        if(!$date1 || !$date2){
            return false;
        }

        return strtotime($value) > strtotime($parameters[0]);
    }
}