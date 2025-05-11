<?php
namespace Hpd\Validatify\Rules;

class RuleRegistry
{
    private static $customRules = [];
    private static $customRuleErrorHandlers = [];

    public static function register(string $ruleName, callable $callback, string $errorHandlerName = 'default'): void
    {
        // Register the custom rule with its callback
        self::$customRules[$ruleName] = $callback;

        // Register the error handler for the custom rule
        self::$customRuleErrorHandlers[$ruleName] = $errorHandlerName;
    }

    public static function isCustomRule(string $ruleName): bool
    {
      
        return isset(self::$customRules[$ruleName]);
    }

    public static function getCustomRule(string $ruleName): ?callable
    {
        return self::$customRules[$ruleName] ?? null;
    }

    public static function getCustomRuleErrorHandler(string $ruleName): string
    {
        return self::$customRuleErrorHandlers[$ruleName] ?? 'default';
    }
}