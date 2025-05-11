<?php
namespace Hpd\Validatify\Rules;

use Hpd\Validatify\Rules\RuleInterface;

class CustomRule implements RuleInterface
{
    protected $callback;
    protected $dependencies;

    public function __construct(callable $callback, array $dependencies = [])
    {
        $this->callback = $callback;
        $this->dependencies = $dependencies;
    }

    public function validate($value, $parameters = null): bool
    {
        // Pass dependencies to the callback
        return call_user_func($this->callback, $value, $parameters, $this->dependencies);
    }
}