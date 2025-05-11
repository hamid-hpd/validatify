<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Hpd\Validatify\Validator;

class EmailRuleTest extends TestCase
{
    public function testValidInput()
    {
        $data = [
            'email' => 'someone@example.com'
        ];

        $rules = [
            'email' => ['email']
        ]; 

        $validator = new Validator($data, $rules);
    ;

        $this->assertTrue($validator->validate());
        // Retrieve errors (should be empty if validation passes)
        $errors = $validator->getErrors();
    
        // Assert that there are no errors
        $this->assertEmpty($errors);
    }

    public function testInvalidInput()
    { 
        // TODO: Implement this test with invalid data
        $data = [ 
            'email' => 'someone@examplecom'
        ];

        $rules = [
            'email' => ['email']
        ]; 
        $validator = new Validator($data, $rules);
        $this->assertFalse($validator->validate());
        $errors = $validator->getErrors();
        $this->assertNotEmpty($errors);
    }
}