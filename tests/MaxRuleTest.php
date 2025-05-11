<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Hpd\Validatify\Validator;
use Hpd\Validatify\Test\Utils\FileMocker;
use Hpd\Validatify\Test\Utils\CleanUp;

class MaxRuleTest extends TestCase
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
        $data = [
            'file' => $tempFile,
            'age' => 25
        ];
        $rules = [
                 'file' => ['max:100kb'],
                 'age' => ['max:30']
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
        $data = [
            'file' => $tempFile,
            'age' => 35
        ];
        $rules = [
                 'file' => ['max:8b'],
                 'age' => ['max:30']
                 ];
                 $validator = new Validator($data, $rules);
    
        $this->assertFalse($validator->validate());
      
        $errors = $validator->getErrors();
             
        // Assert that there are some errors
         $this->assertNotEmpty($errors);  
    }
    protected function tearDown(): void
    {
       CleanUp::deleteFile($this->tempFilePath);
    }
}
