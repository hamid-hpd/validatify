<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Hpd\Validatify\Validator;
use Hpd\Validatify\Test\Utils\FileMocker;
use Hpd\Validatify\Test\Utils\CleanUp;
class ExtensionsRuleTest extends TestCase
{
    private string $tempFilePath;

    protected function setUp(): void
    {
        $this->tempFilePath = '';
    }

    public function testValidInput()
    {
        // Create a temporary file with a valid extension
        $tempFile = FileMocker::createMockFile('example.png','Temp file'); 
        $this->tempFilePath = $tempFile['tmp_name'];
        $file = ['file' => $tempFile];
       $rules = [
                'file' => ['extensions:jpg,jpeg,png']
                ];
                

        $validator = new Validator($file, $rules);
    
            $this->assertTrue($validator->validate());
            // Retrieve errors (should be empty if validation passes)
            $errors = $validator->getErrors();
        
            // Assert that there are no errors
            $this->assertEmpty($errors);
    }

    public function testInvalidInput()
  {
    // Create a temporary file with a valid extension
    $tempFile = FileMocker::createMockFile('example.gif', 'TempFile');
    $this->tempFilePath = $tempFile['tmp_name'];
    $file = ['file' => $tempFile];
    $rules = [
             'file' => ['extensions:jpg,jpeg,png']
             ];
             
     $validator = new Validator($file, $rules);
     
         $this->assertFalse($validator->validate());
    
         // Retrieve errors (should be empty if validation passes)
         $errors = $validator->getErrors();
         $this->assertNotEmpty($errors);
    }

    public function testInavlidInputNoExtension()
    {
      // Create a temporary file with a valid extension
      $tempFile = FileMocker::createMockFile('example', 'TempFile');
      $this->tempFilePath = $tempFile['tmp_name'];
      $file = ['file' => $tempFile];
    $rules = [
             'file' => ['extensions:jpg,jpeg,png']
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