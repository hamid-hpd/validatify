<?php
namespace Tests;
use PHPUnit\Framework\TestCase;
use Hpd\Validatify\Validator;

class AlphaNumRuleTest extends TestCase
{
    public function testValidInput()
    {
        $data = [
            'username' => 'john123',  
        ];

        $rules = [
            'username' => ['required', 'alpha_num'],
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
            'username' => '@john_123',  
        ];

        $rules = [
            'username' => ['required', 'alpha_num']
        ]; 

        $validator = new Validator($data, $rules);
        $this->assertFalse($validator->validate());
        $errors = $validator->getErrors();
        $this->assertNotEmpty($errors);
    }
}