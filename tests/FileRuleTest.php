<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Hpd\Validatify\Validator;
use Hpd\Validatify\Rules\FileRule;
use Hpd\Validatify\Rules\RuleRegistry;

class FileRuleTest extends TestCase
{


    public function testValidUploadedFile()
    {
        // Arrange
        $data = [
            'file' => [
                'name' => 'test.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => '/tmp/php123',
                'error' => UPLOAD_ERR_OK,
                'size' => 1024
            ]
        ];

        $rules = [
            'file' => ['file']
        ];

        // ایجاد یک mock برای FileRule تا رفتار isUploadedFile را کنترل کنیم
        $fileRuleMock = $this->createPartialMock(FileRule::class, ['isUploadedFile']);
        $fileRuleMock->method('isUploadedFile')->willReturn(true);

        // ثبت قانون سفارشی برای استفاده از mock
        RuleRegistry::register('file', function ($value, $parameters = null) use ($fileRuleMock) {
            return $fileRuleMock->validate($value, $parameters);
        });

        $validator = new Validator($data, $rules);

        $result = $validator->validate();

        $this->assertTrue($result, 'Validation should pass for a valid uploaded file.');
        $errors = $validator->getErrors();
        $this->assertEmpty($errors, 'No errors should be present for a valid file.');
    }

    public function testInvalidUploadedFile()
    {
        // Arrange
        $data = [
            'file' => [
                'name' => 'test.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => '/tmp/php123',
                'error' => UPLOAD_ERR_OK,
                'size' => 1024
            ]
        ];

        $rules = [
            'file' => ['file']
        ];

        $fileRuleMock = $this->createPartialMock(FileRule::class, ['isUploadedFile']);
        $fileRuleMock->method('isUploadedFile')->willReturn(false);

        RuleRegistry::register('file', function ($value, $parameters = null) use ($fileRuleMock) {
            return $fileRuleMock->validate($value, $parameters);
        });

        $validator = new Validator($data, $rules);

      
        $result = $validator->validate();

      
        $this->assertFalse($result, 'Validation should fail for an invalid uploaded file.');
        $errors = $validator->getErrors();
        $this->assertNotEmpty($errors, 'Errors should be present for an invalid file.');
    }

    public function testFileWithUploadError()
    {
        // Arrange
        $data = [
            'file' => [
                'name' => 'test.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => '/tmp/php123',
                'error' => UPLOAD_ERR_NO_FILE,
                'size' => 0
            ]
        ];

        $rules = [
            'file' => ['file']
        ];

        $validator = new Validator($data, $rules);

        // Act
        $result = $validator->validate();

        // Assert
        $this->assertFalse($result, 'Validation should fail for a file with upload error.');
        $errors = $validator->getErrors();
        $this->assertNotEmpty($errors, 'Errors should be present for a file with upload error.');
    }

    public function testMissingFileInput()
    {
        // Arrange
        $data = [
            'file' => null
        ];

        $rules = [
            'file' => ['file']
        ];

        $validator = new Validator($data, $rules);

        // Act
        $result = $validator->validate();

        // Assert
        $this->assertFalse($result, 'Validation should fail for missing file input.');
        $errors = $validator->getErrors();
        $this->assertNotEmpty($errors, 'Errors should be present for missing file input.');
    }
    public function testZeroSizeFile()
    {
        // Arrange
        $data = [
            'file' => [
                'name' => 'empty.txt',
                'type' => 'text/plain',
                'tmp_name' => '/tmp/php123',
                'error' => UPLOAD_ERR_OK,
                'size' => 0
            ]
        ];

        $rules = [
            'file' => ['file']
        ];

        $validator = new Validator($data, $rules);

        // Act
        $result = $validator->validate();

        // Assert
        $this->assertFalse($result, 'Validation should fail for an empty file with no upload error.');
        $errors = $validator->getErrors();
        $this->assertNotEmpty($errors, 'Errors should be present for an empty file.');
    }

    
}