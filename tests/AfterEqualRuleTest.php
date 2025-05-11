<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Hpd\Validatify\Validator;

class AfterEqualRuleTest extends TestCase
{
    public function testValidInput()
    {
        $data = [
            'birthdate' => '25-04-1984',
        ];

        $rules = [ 
            'birthdate' => ['after_equal:25-04-1984'],
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
            'birthdate' => '24-04-1984',
        ];
        $rules = [
            'birthdate' => ['required', 'after_equal:25-04-1984'],
        ]; 

        $validator = new Validator($data, $rules);
        $this->assertFalse($validator->validate());  
        $errors = $validator->getErrors();
        $this->assertNotEmpty( $errors); 
    }
}