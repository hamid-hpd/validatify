<?php
namespace Hpd\Validatify\Rules;

class ExtensionsRule implements RuleInterface {
    public function validate($file, $parameters = null): bool {
        $file = $file['name'];
        $fileExtention = pathinfo($file, PATHINFO_EXTENSION);
        return in_array($fileExtention,$parameters);   
    } 
}