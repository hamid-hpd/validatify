<?php
namespace Hpd\Validatify\ErrorHandlers;

class MessageFormatter {
    public static function format($message, $field, $parameters = []): string {
        // Replace {:attr} with the field value
        $formattedMessage = preg_replace_callback('/\{:attr\}/', function() use ($field) {
            return $field;
        }, $message);
    
        // Replace {:params} with comma-separated values from $parameters
        $formattedMessage = preg_replace_callback('/\{:params\}/', function() use ($parameters) {
            return implode(', ', $parameters);
        }, $formattedMessage);
    
        // Replace {:paramX} placeholders with specific values from $parameters
        $formattedMessage = preg_replace_callback('/\{:param(\d+)\}/', function($matches) use ($parameters) {
            $index = (int) $matches[1];
            return isset($parameters[$index]) ? $parameters[$index] : ''; // Handle missing parameter index
        }, $formattedMessage);
        return $formattedMessage;
    }
}