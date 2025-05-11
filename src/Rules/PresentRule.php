<?php
namespace Hpd\Validatify\Rules;
use Hpd\Validatify\Validator;
class PresentRule implements RuleInterface {
    public function validate($value, $parameters = null): bool { 
        //check is it file 
        if($value==Validator::MISSING_KEY){
            return false;
        }
        return true;
    }
}