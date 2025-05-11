<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Hpd\Validatify\Validator;
class NumericRuleTest extends TestCase
{
    public function testValidInput()
    {

        $data = ['age' => 40];
        $rules = [
                 'age' => ['numeric']
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

        $data = ['age' => 'ten'];
        $rules = [
                 'age' => ['numeric']
                 ];
                 $validator = new Validator($data, $rules);
    
        $this->assertFalse($validator->validate());
      
        $errors = $validator->getErrors();
    
         $this->assertNotEmpty($errors);  
    }
}
