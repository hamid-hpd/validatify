<?php
namespace Hpd\Validatify\ErrorHandlers;
class NumericErrorHandler implements ErrorHandlerInterface
{
    private $loader;
    public function __construct(LanguageLoader $loader) {
        $this->loader = $loader;
    }

    public function getMessage($field, $value, $parameters=null, $customMessage = null): string
    {
        if ($customMessage) {
            $error = $customMessage;
        } else {
            $messages = $this->loader->getMessages();
            $error = $messages['numeric'];
        }

        return MessageFormatter::format($error, $field, $parameters);
    }
   
}