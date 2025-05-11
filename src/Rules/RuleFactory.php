<?php
namespace Hpd\Validatify\Rules;

namespace Hpd\Validatify\Rules;

use Hpd\Validatify\Dependency;

class RuleFactory
{
    public static function create(string $ruleName)
    {
        // Check if the rule is a custom rule
        if (RuleRegistry::isCustomRule($ruleName)) {
            $callback = RuleRegistry::getCustomRule($ruleName);
            $dependencies = Dependency::get($ruleName) ?? [];
            return new CustomRule($callback, $dependencies);
        }

        // Resolve the regular rule class
        $ruleClass = self::resolveRuleClass($ruleName);

        // Handle dependency injection for regular rules
        $dependencies = Dependency::get($ruleName) ?? [];
        return new $ruleClass(...array_values($dependencies));
    }

    private static function resolveRuleClass(string $ruleName): string
    {
        $rule = ucfirst(lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $ruleName)))));
        $ruleClass = __NAMESPACE__ . '\\' . $rule . 'Rule';
        if (!class_exists($ruleClass)) {
            throw new \InvalidArgumentException("Rule class '$ruleClass' does not exist.");
        }
        return $ruleClass;
    }
}