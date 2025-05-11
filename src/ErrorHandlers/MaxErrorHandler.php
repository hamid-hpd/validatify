<?php
namespace Hpd\Validatify\ErrorHandlers;
class MaxErrorHandler implements ErrorHandlerInterface
{
    private $loader;

    public function __construct(LanguageLoader $loader) {
        $this->loader = $loader;
    }

    public function getMessage($field, $value, $parameters = null, $customMessage = null): string
    {
        if ($customMessage) {
            $error = $customMessage;
        } else {
            $type=$this->getType($value);
            $messages = $this->loader->getMessages();
            $error = $messages['max'][$type];

        }
        return MessageFormatter::format($error, $field, $parameters);
    }
    private function getType($value):string{
        if(is_array($value)){
            return 'file';
        }
        if(is_numeric($value)){
            return 'numeric';
        }
    }
}