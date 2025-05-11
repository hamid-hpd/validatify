<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Hpd\Validatify\Validator;

class LengthRuleTest extends TestCase
{

    public function testValidInput()
    {
        $data = [
            'zipCode' => 1425856901,  
        ];

        $rules = [
            'zipCode' => ['length:10'],
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
        $data = [
            'zipCode' => 123456789012,  
        ];

        $rules = [
            'zipCode' => ['length:10']
        ]; 
        $validator = new Validator($data, $rules);
        $this->assertFalse($validator->validate());
        $errors = $validator->getErrors();
        $this->assertNotEmpty($errors);
    }
}
