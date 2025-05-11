<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Hpd\Validatify\Validator;

class PresentRuleTest extends TestCase
{
    public function testValidInput()
    {
        $data = [
            'name'=>'Jason',
            'age' => 25
           ];
           $rules =[
            'name'=> ['alpha'],
            'age' => ['present']
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
            'name'=>'Jason'
           ];
           $rules =[
            'name'=> ['alpha'],
            'age' => ['present']
           ];
    
    $validator = new Validator($data, $rules);  
           $this->assertFalse($validator->validate());
           // Retrieve errors (should be empty if validation passes)
           $errors = $validator->getErrors();
            $this->assertNotEmpty($errors);
    }
}
