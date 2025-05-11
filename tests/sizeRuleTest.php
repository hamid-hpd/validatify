<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Hpd\Validatify\Validator;
use Hpd\Validatify\Test\Utils\FileMocker;
use Hpd\Validatify\Test\Utils\CleanUp;

class sizeRuleTest extends TestCase
{
    protected $tempFilePath;

    protected function setUp(): void
    {
        $this->tempFilePath='';
    }

    public function testValidInput()
    {
        $tempFile=FileMocker::createMockFile('example.txt','Temp file');
        $this->tempFilePath = $tempFile['tmp_name'];
        $data = ['file' => $tempFile];
        $rules = [
                 'file' => ['size:9b']
                 ];
                 $validator = new Validator($data, $rules);
    
        $this->assertTrue($validator->validate());
        // Retrieve errors (should be empty if validation passes)
        $errors = $validator->getErrors();
             
        // Assert that there are no errors
         $this->assertEmpty($errors);                 
    }

    public function testInvalidInput()
    {
        $tempFile=FileMocker::createMockFile('example.txt','Temp file');
        $this->tempFilePath = $tempFile['tmp_name'];
        $data = ['file' => $tempFile];
        $rules = [
                 'file' => ['size:100b']
                 ];
                 $validator = new Validator($data, $rules);
    
        $this->assertFalse($validator->validate());
        // Retrieve errors (should be empty if validation passes)
        $errors = $validator->getErrors();
             
        // Assert that there are no errors
         $this->assertNotEmpty($errors);  
    }
    protected function tearDown(): void
    {
       CleanUp::deleteFile($this->tempFilePath);
    }
}
