<?php

namespace Hpd\Validatify\Rules;

class AfterEqualRule implements RuleInterface {
    public function validate($value, $parameters = null): bool {
        $date=new dateRule();
        $date1=$date->validate($value);
        $date2=$date->validate($parameters[0]);
        if(!$date1 || !$date2){
            return false;
        }
        return strtotime($value) >= strtotime($parameters[0]);
    }
}
class DateRule implements RuleInterface {
    public function validate($value, $parameters = null): bool {
        if ($value instanceof DateTimeInterface) {
        return true;
        }

        try {
            if ((!is_string($value) && !is_numeric($value)) || strtotime($value) === false) {
                return false;
            }
            
            $dateComponents = date_parse($value);

            // Ensure there are no errors and the date is valid
            return $dateComponents['error_count'] === 0 && checkdate($dateComponents['month'], $dateComponents['day'], $dateComponents['year']);

        } catch (Throwable $t) {
            return false;
        }

    }
}