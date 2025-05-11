<?php
namespace Hpd\Validatify\ErrorHandlers;
use Hpd\Validatify\ErrorHandlers\LanguageLoader;

class ErrorHandlerFactory{
    public static function create($errorHandlerName){
        $langLoader = LanguageLoader::getInstance();
        $handlerName=ucfirst(lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $errorHandlerName)))));        
        $className = __NAMESPACE__ . "\\" . $handlerName . "ErrorHandler";
        return new $className($langLoader);
    }
}