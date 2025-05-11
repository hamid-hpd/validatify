<?php
namespace Hpd\Validatify\Test\Utils;
class FileMocker{
public static function createMockFile(string $filename, string $content){
        // Create a temporary file in the system's temporary directory
        $tempDir = sys_get_temp_dir();
        
        $tempFilePath = $tempDir . DIRECTORY_SEPARATOR . $filename;
        // Create the file
        file_put_contents($tempFilePath, $content);

        // Return a mock file array
        return [
            'name' => $filename,
            'type' => mime_content_type($tempFilePath),
            'tmp_name' => $tempFilePath,
            'error' => UPLOAD_ERR_OK,
            'size' => filesize($tempFilePath),
        ];
}
}
