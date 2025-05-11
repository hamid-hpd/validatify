<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Hpd\Validatify\Validator;

class MaxLengthRuleTest extends TestCase
{
    public function testValidStringInput()
    {
        $data = [
            'username' => 'jackx25',  
        ];

        $rules = [
            'username' => ['maxLength:8'],
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
            'username' => 'jasonx2025',  
        ];

        $rules = [
            'username' => ['maxLength:8']
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
            'year' => ['maxLength:4'],
        ]; 

        $validator = new Validator($data, $rules);
        $this->assertTrue($validator->validate());
  
        // Retrieve errors (should be empty if validation passes)
        $errors = $validator->getErrors();

        $this->assertEmpty($errors);
    }

    public function testInvalidNumericInput()
    {
        $data = [
            'year' => 11994,  
        ];

        $rules = [
            'year' => ['maxLength:4']
        ]; 
        $validator = new Validator($data, $rules);
        $this->assertFalse($validator->validate());
        $errors = $validator->getErrors();
        $this->assertNotEmpty($errors);
    }
}
