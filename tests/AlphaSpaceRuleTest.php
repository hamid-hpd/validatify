<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Hpd\Validatify\Validator;
class AlphaSpaceRuleTest extends TestCase
{
    public function testValidInput()
    {
        $data = [
            'username' => 'john Smith',  
        ];

        $rules = [
            'username' => ['alpha_space'],
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
            'username' => 'john_smith'
        ];

        $rules = [
            'username' => ['alpha_space']
        ]; 
        $validator = new Validator($data, $rules);
        $this->assertFalse($validator->validate());
        $errors = $validator->getErrors();
        $this->assertNotEmpty( $errors);
    }
}