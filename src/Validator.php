<?php
namespace Hpd\Validatify;

use Hpd\Validatify\Rules\RuleFactory;
use Hpd\Validatify\ErrorHandlers\ErrorHandlerFactory;
use Hpd\Validatify\Rules\RuleRegistry;

class Validator
{
    protected $data;
    protected $rules;
    protected $messages;
    protected $errors = [];
    protected $stopOnFirstFailure = false;

    const MISSING_KEY = '__MISSING_KEY__';
    protected array $typeDependentRules = [
        'minSize'    => ['numeric', 'file'],
        'maxSize'    => ['numeric', 'file'],
        'size'        => ['numeric', 'file'],
        'minLength'  => ['string','numeric','countable'],
        'maxLength'  => ['string', 'numeric','countable'],
        'length'      => ['string', 'numeric','countable'],
    ];
    public function __construct(array $data, array $rules, array $messages = [])
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->messages = $messages;
    }

    public function validate(): bool
    {
        foreach ($this->rules as $field => $fieldRules) {
            // Convert pipe-separated rules to an array if necessary
            $fieldRulesArray = $this->normalizeRules($fieldRules);

            if ($this->shouldBeValidated($field, $fieldRulesArray)) {
                if (strpos($field, '.*') !== false) {
                    $this->validateWildcardField($field, $fieldRulesArray);
                } else {
                    $this->validateField($field, $fieldRulesArray);
                }

                if (!empty($this->errors) && $this->stopOnFirstFailure) {
                    return false;
                }
            }
        }

        return empty($this->errors);
    }

    protected function validateField(string $field, array $fieldRules, $value = null): void
    {
        // If $value is not provided, fetch it using getValue
        if ($value === null) {
            $value = $this->getValue($field);
        }

        $fieldErrors = [];
        $halt = false;

        // If the nullable rule is present and the value is null, skip further validation
        if (in_array('nullable', $fieldRules, true) &&( $value === null || $value==='' )){
            return;
        }

        foreach ($fieldRules as $rule) {
            if ($rule === 'nullable') {
                continue;
            }
            if ($rule === 'halt') {
                $halt = true;
                continue;
            }

            // Separate the rule name and its values
            $ruleParts = $this->parseRule($rule);
            $ruleName = $ruleParts[0];
            $ruleValues = $ruleParts[1];

            if (isset($this->typeDependentRules[$ruleName])) {
                // Check if the rule is type-dependent
                $type = $this->detectType($value);
                
                // If the type is not in the list of allowed types for this rule, skip it
                if (!in_array($type, $this->typeDependentRules[$ruleName], true)) {
                    continue;
                }
            }
            // Create the rule instance
            $validator = RuleFactory::create($ruleName);

            // Validate the rule
            if (!$validator->validate($value, $ruleValues)) {
               
                // Get the error handler for the rule
                $errorHandlerName = RuleRegistry::isCustomRule($ruleName)
                    ? RuleRegistry::getCustomRuleErrorHandler($ruleName)
                    : $ruleName;

                $errorHandler = ErrorHandlerFactory::create($errorHandlerName);

                // Retrieve the custom message if it exists
                $customMessageKey = "{$field}.{$ruleName}";
                $customMessage = $this->messages[$customMessageKey] ?? null;

                // Add the error message
                $fieldErrors[] = $errorHandler->getMessage($field, $value, $ruleValues, $customMessage);

                if ($halt) {
                    break;
                }
                if ($this->stopOnFirstFailure) {
                    $this->errors[$field] = $fieldErrors;
                    return;
                }
            }
        }

        if (!empty($fieldErrors)) {
            $this->errors[$field] = $fieldErrors;
        }
    }

    protected function validateWildcardField(string $field, array $fieldRules): void
    {
        // Find the first “.*”
        $pos = strpos($field, '.*');
        $baseField = substr($field, 0, $pos);
        // Everything after the “*” — may be “.name”, “.price”, or empty for “scores.*”
        $suffix = substr($field, $pos + 2);
    
        $values = $this->getValue($baseField);
    
        if (is_array($values)) {
            foreach (array_keys($values) as $idx) {
                // e.g. "users" + "." + "0" + ".name"  => "users.0.name"
                $nestedField = $baseField . '.' . $idx . $suffix;
                $this->validateField($nestedField, $fieldRules);
                if ($this->stopOnFirstFailure && !empty($this->errors)) {
                    return;
                }
            }
        } else {
            // If it's not an array after all, just validate the base+suffix once
            $this->validateField($baseField . $suffix, $fieldRules);
        }
    }
    

    protected function shouldBeValidated(string $field, array $rules): bool
    {
    // Check if the field contains a wildcard
    if (strpos($field, '.*') !== false) {
        // Use only the base field for existence check
        $pos = strpos($field, '.*');
        $baseField = substr($field, 0, $pos);
        $value = $this->getValue($baseField);
    } else {
        $value = $this->getValue($field);
    }
        if ($value === self::MISSING_KEY) {
          
            // If the field is missing, it should be validated if 'required' or 'present' is in the rules
            return in_array('required', $rules, true) || in_array('present', $rules, true);
        }
        if ($value === null && in_array('nullable', $rules, true)) {
            return false;
        }

        // Always validate if the field is present
        return true;
    }

    protected function getValue(string $field)
    {
        $keys = explode('.', $field);
        $value = $this->data;

        foreach ($keys as $key) {
            if (is_array($value) && array_key_exists($key, $value)) {
                $value = $value[$key];
            } else {
                return self::MISSING_KEY;
            }
        }

        return $value;
    }

    protected function parseRule(string $rule): array
    {
        $ruleParts = explode(':', $rule);
        $ruleName = $ruleParts[0];
        $ruleValues = isset($ruleParts[1]) ? explode(',', $ruleParts[1]) : [];
        return [$ruleName, $ruleValues];
    }

    protected function normalizeRules($rules): array
    {
        // If the rules are already an array, return them as-is
        if (is_array($rules)) {
            return $rules;
        }

        // If the rules are a string, split them by the pipe character and trim whitespace
        return array_map('trim', explode('|', $rules));
    }

    public function getErrors($key = null): ?array
    {
        if ($key === null) {
            return empty($this->errors) ? null : $this->errors;
        } else {
            return $this->errors[$key] ?? null;
        }
    }

    public function stopOnFirstFailure(bool $stopOnFirstFailure): void
    {
        $this->stopOnFirstFailure = $stopOnFirstFailure;
    }
    protected function detectType($value): ?string
{

    if (is_array($value) && isset($value['tmp_name'], $value['error']))return 'file';
    if (is_array($value)) return 'countable';
    if (is_numeric($value)) return 'numeric';
    if (is_string($value)) return 'string';
    if ($value instanceof \SplFileInfo || (is_array($value) && isset($value['tmp_name']))) return 'file';

    return null;
}

}