<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Hpd\Validatify\Validator;
use Hpd\Validatify\Test\Utils\FileMocker;
use Hpd\Validatify\Test\Utils\CleanUp;

class MimesRuleTest extends TestCase
{
    protected $tempFilePath;
    protected function setUp(): void
    {
        $this->tempFilePath = '';
    }
    public function testValidInput()
    {
        // Create a temporary file with a valid extension;
        $tempFile=FileMocker::createMockFile('example.txt','Temp file');
        $this->tempFilePath = $tempFile['tmp_name'];
        if (!empty($this->tempFilePath) && file_exists($this->tempFilePath)) {
            unlink($this->tempFilePath);
        }
        $rules = [
                'file' => ['mimes:txt,doc,pdf']
                ];
        $validator = new Validator($tempFile, $rules);
    
            $this->assertTrue($validator->validate());
            // Retrieve errors (should be empty if validation passes)
            $errors = $validator->getErrors();
            // Assert that there are no errors
            $this->assertEmpty($errors);
    }
    public function testInValidInput()
    {
        // Create a temporary file with an Invalid extension
        $tempFile=FileMocker::createMockFile('example.txt','Temp file');
        $this->tempFilePath = $tempFile['tmp_name'];
        $file =['file' => $tempFile];
        $rules = [
                'file' => ['mimes:jpg,gif,png']
                ];
                
        $validator = new Validator($file, $rules);
    
            $this->assertFalse($validator->validate());
            // Retrieve errors (should be empty if validation passes)
            $errors = $validator->getErrors();
            $this->assertNotEmpty($errors);
    }
    protected function tearDown(): void
    {
      CleanUp::deleteFile($this->tempFilePath);
    }

}
