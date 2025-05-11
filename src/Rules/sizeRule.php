<?php

namespace Hpd\Validatify\Rules;

class SizeRule implements RuleInterface {
    public function validate($value, $parameters = null): bool {
        if(isset($value['tmp_name']) && $value['error'] == UPLOAD_ERR_OK ){
            $fileSize=filesize($value['tmp_name']);
            $maxSize=self::toBytes($parameters[0]); 
            return $fileSize == $maxSize;
        }
            
        if(is_numeric($value)){
            return $value == $parameters[0];
        }
            return false;
    }
    
    private static function toBytes($str) {
        $str = strtolower($str);
        $units = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
        $number = (float)$str;
        $unit = str_replace((string)$number, '', $str); // get the unit of size
        $exponent = array_search($unit, $units); // get the exponent of the unit
        if ($exponent === false) {
            return false; // unit not found
        }
        return $number * pow(1024, $exponent);
    }
}