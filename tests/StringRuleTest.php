<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Hpd\Validatify\Validator;

class StringRuleTest extends TestCase
{

    public function testValidInput()
    {
        $data = ['username' => "jasonx52"];
        $rules = [
                 'username' => ['string']
                 ];
        $validator = new Validator($data, $rules);
    
        $this->assertTrue($validator->validate());
      
        $errors = $validator->getErrors();
             
        // Assert that there are no errors
         $this->assertEmpty($errors);  
    }

    public function testInvalidInput()
    {
        $data = ['username' => 123];
        $rules = [
                 'username' => ['string']
                 ];
                 $validator = new Validator($data, $rules);
    
        $this->assertFalse($validator->validate());
      
        $errors = $validator->getErrors();

         $this->assertNotEmpty($errors);  
    }
}
