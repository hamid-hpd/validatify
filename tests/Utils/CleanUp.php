<?php
namespace Hpd\Validatify\Test\Utils;
class CleanUp{
    public static function deleteFile($tempFilePath){

            // Delete the temporary file if it exists
            if (!empty($tempFilePath) && file_exists($tempFilePath)) {
                unlink($tempFilePath);
            }
    }
}