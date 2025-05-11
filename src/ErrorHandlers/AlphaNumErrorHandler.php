<?php
namespace Hpd\Validatify\ErrorHandlers;
class AlphaNumErrorHandler implements ErrorHandlerInterface
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
            $error = $messages['alpha_num'];
        }

        return MessageFormatter::format($error, $field, $parameters);
    }
   
}