<?php

namespace Hpd\Validatify\Rules;

use Hpd\Validatify\Validator;
class RequiredRule implements RuleInterface {
    public function validate($value, $parameters = null): bool { 
        //check is it file
       if(isset($value['tmp_name'])){
                if(isset($value['error']) && $value["error"] == UPLOAD_ERR_OK && $value['size'] >0){
                    return true;
                }else{
                    return false;
                }
        }  
        if($value==Validator::MISSING_KEY || is_null($value) || 
            (is_string($value) && trim($value) === "" ) || $value==[]){
            return false;

        }
        return true;
    }
}