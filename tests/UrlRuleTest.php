<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Hpd\Validatify\Validator;

class UrlRuleTest extends TestCase
{
    public function testValidInput()
    {
        $data = ['url' => "https://example.com"];
        $rules = [
                 'url' => ['url']
                 ];
        $validator = new Validator($data, $rules);
    
        $this->assertTrue($validator->validate());
      
        $errors = $validator->getErrors();
             
        // Assert that there are no errors
         $this->assertEmpty($errors); 
    }

    public function testInvalidInput()
    {
        $data = ['url' => "example.com"];
        $rules = [
                 'url' => ['url']
                 ];
        $validator = new Validator($data, $rules);
    
        $this->assertFalse($validator->validate());
      
        $errors = $validator->getErrors();
      
         $this->assertNotEmpty($errors); 
    }
}
