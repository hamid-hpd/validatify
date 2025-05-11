<?php

namespace Hpd\Validatify\Rules;

class FileRule implements RuleInterface {

    public function validate($value, $parameters = null): bool
    {
        if (isset($value['error']) && $value['error'] == UPLOAD_ERR_OK && $value['size'] > 0) {
           
            return $this->isUploadedFile($value["tmp_name"]);
        }

        return false;
    }

    // Wrapper method for is_uploaded_file
    public function isUploadedFile(string $tmpName): bool
    {
        return is_uploaded_file($tmpName);
    }
}