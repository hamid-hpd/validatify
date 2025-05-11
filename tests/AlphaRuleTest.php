<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Hpd\Validatify\Validator;

class AlphaRuleTest extends TestCase
{
    public function testValidInput()
    {
        $data = [
            'username' => 'john',  
        ];

        $rules = [
            'username' => ['required', 'alpha'],
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
            'username' => 'john_123',  
            'birthdate' => '26-04-1984',
        ];

        $rules = [
            'username' => ['required', 'alpha'],
            'birthdate' => ['required', 'after:25-04-1984'],
        ]; 

        $validator = new Validator($data, $rules);
        $this->assertFalse($validator->validate());
        $errors = $validator->getErrors();
        $this->assertNotEmpty($errors);
    }
}
