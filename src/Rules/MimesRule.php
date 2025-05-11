<?php
namespace Hpd\Validatify\Rules;

class MimesRule implements RuleInterface {
    public function validate($file, $parameters = null): bool {
        try {

            $finfo=finfo_open(FILEINFO_MIME_TYPE);
        
            $mimeType=finfo_file($finfo,$file['tmp_name']); 
            finfo_close($finfo);
        
            $mimeToExt=include_once(__DIR__."../../../config/mime.php");
            if (!array_key_exists($mimeType, $mimeToExt)) {
                return false;
            }
            // Get the array of possible file extensions for this MIME type
            $possibleExtensions = $mimeToExt[$mimeType]; 
            // Check if the $possible Extensions matches any of the allowed extensions
            $commonExtensions = array_intersect($possibleExtensions, $parameters);
            if (!empty($commonExtensions)) {
                return true;
            } 
            return false;  
        } catch (\Throwable $t) {
            return false;
        }
  
    } 
}