<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Hpd\Validatify\Validator;
use Hpd\Validatify\Rules\RuleRegistry;

class CustomRuleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Reset RuleRegistry if available
        // For now, we'll register the rule in each test for isolation
    }

    protected function registerIsEvenRule(): void
    {
        RuleRegistry::register(
            'isEven',
            function ($value, $parameters = null) {
                return is_numeric($value) && $value % 2 === 0;
            },
            'default'
        );
    }

    public function testValidInput(): void
    {
        $this->registerIsEvenRule();

        $data = ['number' => 4];
        $rules = ['number' => ['isEven']];
        $validator = new Validator($data, $rules);

        $this->assertTrue($validator->validate(), 'Validation should pass for even number.');
        $this->assertEmpty($validator->getErrors(), 'No errors should be present for valid input.');
    }

    public function testInvalidInput(): void
    {
        $this->registerIsEvenRule();

        $data = ['number' => 3];
        $rules = ['number' => ['isEven']];
        $messages = ['number.isEven' => 'The :field must be an even number.'];
        $validator = new Validator($data, $rules, $messages);

        $this->assertFalse($validator->validate(), 'Validation should fail for odd number.');
        $errors = $validator->getErrors();
        $this->assertNotEmpty($errors, 'Errors should be present for invalid input.');
        $this->assertEquals(
            ['The :field must be an even number.'],
            $errors['number'],
            'Error message should match custom message.'
        );
    }

    public function testNonNumericInput(): void
    {
        $this->registerIsEvenRule();

        $data = ['number' => 'text'];
        $rules = ['number' => ['isEven']];
        $validator = new Validator($data, $rules);

        $this->assertFalse($validator->validate(), 'Validation should fail for non-numeric input.');
        $this->assertNotEmpty($validator->getErrors(), 'Errors should be present for non-numeric input.');
    }

    public function testNullableInput(): void
    {
        $this->registerIsEvenRule();

        $data = ['number' => null];
        $rules = ['number' => ['nullable', 'isEven']];
        $validator = new Validator($data, $rules);

        $this->assertTrue($validator->validate(), 'Validation should pass for null value with nullable rule.');
        $this->assertEmpty($validator->getErrors(), 'No errors should be present for nullable null input.');
    }

    public function testMissingFieldWithRequired(): void
    {
        $this->registerIsEvenRule();

        $data = [];
        $rules = ['number' => ['required', 'isEven']];
        $messages = ['number.required' => 'The :field is required.'];
        $validator = new Validator($data, $rules, $messages);

        $this->assertFalse($validator->validate(), 'Validation should fail for missing required field.');
        $errors = $validator->getErrors();
        $this->assertEquals(
            ['The :field is required.', 'The number field is not valid.'],
            $errors['number'],
            'Error messages should include required and isEven errors.'
        );
    }

    public function testStopOnFirstFailure(): void
    {
        $this->registerIsEvenRule();

        $data = ['number' => 3];
        $rules = ['number' => ['isEven', 'required']];
        $messages = ['number.isEven' => 'The :field must be an even number.'];
        $validator = new Validator($data, $rules, $messages);
        $validator->stopOnFirstFailure(true);

        $this->assertFalse($validator->validate(), 'Validation should fail and stop on first failure.');
        $errors = $validator->getErrors();
        $this->assertCount(1, $errors['number'], 'Only one error should be reported with stopOnFirstFailure.');
        $this->assertEquals(
            ['The :field must be an even number.'],
            $errors['number'],
            'Error message should match custom message.'
        );
    }

    public function testCustomRuleWithParameters(): void
    {
        RuleRegistry::register(
            'isEvenWithMin',
            function ($value, $parameters = null) {
                $min = isset($parameters[0]) ? (int)$parameters[0] : 0;
                return is_numeric($value) && $value % 2 === 0 && $value >= $min;
            },
            'default'
        );

        $data = ['number' => 6];
        $rules = ['number' => ['isEvenWithMin:4']];
        $validator = new Validator($data, $rules);

        $this->assertTrue($validator->validate(), 'Validation should pass for even number above minimum.');
        $this->assertEmpty($validator->getErrors(), 'No errors should be present for valid input.');

        $data = ['number' => 2];
        $validator = new Validator($data, $rules);
        $this->assertFalse($validator->validate(), 'Validation should fail for even number below minimum.');
        $this->assertNotEmpty($validator->getErrors(), 'Errors should be present for invalid input.');
    }
}