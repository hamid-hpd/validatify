<?php
namespace Hpd\Validatify\ErrorHandlers;

class DefaultErrorHandler implements ErrorHandlerInterface
{
    private $loader;

    public function __construct(LanguageLoader $loader)
    {
        $this->loader = $loader;
    }

    public function getMessage($field, $value, $parameters = [], $customMessage = null): string
    {
        if ($customMessage) {
            return $customMessage;
        }

        $messages = $this->loader->getMessages();
        return MessageFormatter::format($messages['default'], $field, $parameters);
    }
}