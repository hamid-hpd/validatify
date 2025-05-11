<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Hpd\Validatify\Validator;

class IpRuleTest extends TestCase
{
    public function testValidInput()
    {
        $data = [
            'ip' => '127.0.0.1',  
        ];

        $rules = [
            'ip' => ['ip'],
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
            'ip' => '127-0-0-1',  
        ];

        $rules = [
            'ip' => ['ip']
        ]; 
        $validator = new Validator($data, $rules);
        $this->assertFalse($validator->validate());
        $errors = $validator->getErrors();
        $this->assertNotEmpty($errors);
    }
}
