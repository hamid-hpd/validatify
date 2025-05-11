<?php
namespace Hpd\Validatify\ErrorHandlers;

interface ErrorHandlerInterface
{
    public function getMessage($field,$value, $parameters = [], $customMessage = null): string;
}
