<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Hpd\Validatify\Validator;
use Hpd\Validatify\Dependency;
use PDO;
use PDOStatement;

class UniqueRuleTest extends TestCase
{
    private $dbMock;
    private $stmtMock;

    protected function setUp(): void
    {
        // Mock PDO and PDOStatement
        $this->dbMock = $this->createMock(PDO::class);
        $this->stmtMock = $this->createMock(PDOStatement::class);

        // Register PDO dependency for UniqueRule
        Dependency::set('unique', [$this->dbMock]);
    }

    public function testValidUniqueInput()
    {
        // Arrange
        $data = [
            'email' => 'test@example.com'
        ];

        $rules = [
            'email' => ['unique:users,email']
        ];

        // Set up the mock to return count = 0 (unique value)
        $this->stmtMock->method('fetchColumn')->willReturn(0);
        $this->dbMock->method('prepare')->willReturn($this->stmtMock);
        $this->stmtMock->method('execute')->willReturn(true);

        $validator = new Validator($data, $rules);

        // Act
        $result = $validator->validate();

        // Assert
        $this->assertTrue($result);
        $errors = $validator->getErrors();
        $this->assertEmpty($errors);
    }

    public function testInvalidNonUniqueInput()
    {
        // Arrange
        $data = [
            'email' => 'test@example.com'
        ];

        $rules = [
            'email' => ['unique:users,email']
        ];

        // Set up the mock to return count = 1 (non-unique value)
        $this->stmtMock->method('fetchColumn')->willReturn(1);
        $this->dbMock->method('prepare')->willReturn($this->stmtMock);
        $this->stmtMock->method('execute')->willReturn(true);

        $validator = new Validator($data, $rules);

        // Act
        $result = $validator->validate();

        // Assert
        $this->assertFalse($result);
        $errors = $validator->getErrors();
        $this->assertNotEmpty($errors);
        $this->assertArrayHasKey('email', $errors);
    }

    public function testMissingParametersThrowsException()
    {
        // Arrange
        $data = [
            'email' => 'test@example.com'
        ];

        $rules = [
            'email' => ['unique:users'] // Missing column name
        ];

        $validator = new Validator($data, $rules);

        // Assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Unique rule requires both table name and column name.");

        // Act
        $validator->validate();
    }

    protected function tearDown(): void
    {
        // Clear dependencies after each test
        Dependency::set('unique', []);
    }
}