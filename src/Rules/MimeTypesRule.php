<?php
namespace Hpd\Validatify\Rules;

class MimeTypesRule implements RuleInterface {
    public function validate($file, $parameters = null): bool {
        try{
            $finfo=finfo_open(FILEINFO_MIME_TYPE);
            $mimeType=finfo_file($finfo,$file['tmp_name']); 
            finfo_close($finfo);
            return in_array($mimeType,$parameters); 
        }catch(\Throwable){
            return false;
        }
  
    } 
}