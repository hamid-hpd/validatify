<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Hpd\Validatify\Validator;

class BooleanRuleTest extends TestCase
{
    public function testValidInput()
    {
        $data = [
            'accept' => true,
        ];

        $rules = [ 
            'accept' => ['boolean'],
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
            'accept' => '123c',
        ];
        $rules = [
            'accept' => ['boolean'],
        ]; 

        $validator = new Validator($data, $rules);
        $this->assertFalse($validator->validate());  
        $errors = $validator->getErrors();
        $this->assertNotEmpty($errors); 
    }
}