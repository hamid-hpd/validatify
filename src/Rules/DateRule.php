<?php

namespace Hpd\Validatify\Rules;

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

