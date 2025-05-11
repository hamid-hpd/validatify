<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Hpd\Validatify\Validator;

class MinLengthRuleTest extends TestCase
{ 
    public function testValidStringInput()
        {    
        $data = [
            'username' => 'jackx25',  
        ];

        $rules = [
            'username' => ['minLength:5'],
        ]; 

        $validator = new Validator($data, $rules);
        $this->assertTrue($validator->validate());

        // Retrieve errors (should be empty if validation passes)
        $errors = $validator->getErrors();

        // Assert that there are no errors
        $this->assertEmpty($errors);
    }

    public function testInvalidStringInput()
    {
        $data = [
            'username' => 'jack',  
        ];

        $rules = [
            'username' => ['minLength:5']
        ]; 
        $validator = new Validator($data, $rules);
        $this->assertFalse($validator->validate());
        $errors = $validator->getErrors();
        $this->assertNotEmpty($errors);
    }
    public function testValidNumericInput()
    {
        $data = [
            'year' => 1994,  
        ];

        $rules = [
            'year' => ['minLength:4'],
        ]; 

        $validator = new Validator($data, $rules);
        $this->assertTrue($validator->validate());
  
        // Retrieve errors (should be empty if validation passes)
        $errors = $validator->getErrors();
    
        // Assert that there are no errors
        $this->assertEmpty($errors);
    }

    public function testInvalidNumericInput()
    {
        $data = [
            'year' => 94,  
        ];

        $rules = [
            'year' => ['minLength:4']
        ]; 
        $validator = new Validator($data, $rules);
        $this->assertFalse($validator->validate());
        $errors = $validator->getErrors();
        $this->assertNotEmpty($errors);
    }
}
