<?php

use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\TestCase;
use Hpd\Validatify\Test\TestUtils;
use Hpd\Validatify\Validator;
use Hpd\Validatify\Rules\FileRule;
class ValidatorTest extends TestCase
{
    public function testStopsOnFirstFailure()
    {
        $data = [
            'username' => 'john_doe',
            'email' => 'Invalid_Email',
            'age' => "Ten",
        ];

        $rules = [
            'username' => ['required', 'alpha_dash'],
            'email' => ['required', 'email'],
            'age' => ['required', 'integer'],
        ];

        $validator = new Validator($data, $rules);
        
        // Use the method to enable stopping on the first failure
        $validator->stopOnFirstFailure(true);

        $this->assertFalse($validator->validate());

        $errors = $validator->getErrors();
        $this->assertArrayHasKey('email', $errors);
        $this->assertArrayNotHasKey('age', $errors); // Age is not checked because email failed first
    }
    public function testMissingField()
    {
        $data = [
            'email' => 'john.doe@example.com',
        ];

        $rules = [
            'email' => ['required', 'email'],
            'age' => ['required', 'integer'],
        ];

        $validator = new Validator($data, $rules);
        $this->assertFalse($validator->validate());

        $errors = $validator->getErrors();
        $this->assertArrayHasKey('age', $errors);
    }

        public function testNullableField()
    {
        $data = [
            'username' => 'john_doe',
            'email' => null,
        ];

        $rules = [
            'username' => ['required', 'alpha_dash'],
            'email' => ['nullable', 'email'],
        ];

        $validator = new Validator($data, $rules);
        $this->assertTrue($validator->validate());
    
    }
    
}