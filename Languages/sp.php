<?php
return [
    'accepted' => 'El campo {:attr} debe ser aceptado.',
    'after' => 'El {:attr} debe ser una fecha después de {:param0}.',
    'after_equal' => 'El {:attr} debe ser una fecha después o igual a {:param0}.',
    'alpha' => 'El campo {:attr} solo puede contener letras.',
    'alpha_dash' => 'El campo {:attr} solo puede contener letras, números, guiones y guiones bajos.',
    'alpha_num' => 'El campo {:attr} solo puede contener letras y números.',
    'alpha_space' => 'El campo {:attr} solo puede contener letras y espacios.',
    'array' => 'El campo {:attr} debe ser un array.',
    'before' => 'El {:attr} debe ser una fecha antes de {:param0}.',
    'before_equal' => 'El {:attr} debe ser una fecha antes o igual a {:param0}.',
    'boolean' => 'El campo {:attr} solo puede ser verdadero o falso.',
    'date' => 'El campo {:attr} debe ser una fecha válida.',
    'email' => 'El campo {:attr} debe ser una dirección de correo electrónico válida.',
    'extensions' => 'El campo {:attr} debe tener una de las siguientes extensiones: {:params}',
    'file' => 'El campo {:attr} debe ser un archivo.' ,
    'image' => 'El {:attr} debe ser una imagen.',
    'integer' => 'El campo {:attr} debe ser un número entero.',
    'ip' => 'El campo {:attr} debe ser una dirección IP válida',
    'length' => [
        'countable' => 'El campo {:attr} debe contener {:param0} elementos.',
        'digits' => 'El campo {:attr} debe tener {:param0} dígitos.',
        'string' => 'El campo {:attr} debe tener {:param0} caracteres.',       
    ],
    'max_length' => [
        'countable' => 'El campo {:attr} no debe tener más de {:param0} elementos.',
        'digits' => 'El campo {:attr} no debe tener más de {:param0} dígitos.',
        'string' => 'El campo {:attr} no debe tener más de {:param0} caracteres.'
    ],
    'max' => [
        'file' => 'El campo {:attr} no debe ser mayor de {:param0} .',
        'numeric' => 'El campo {:attr} no debe ser mayor que {:param0}',
    ],
    'mimes' => 'El campo {:attr} debe ser un archivo de tipo: {:params}',
    'mime_types' => 'El campo {:attr} debe ser un archivo de tipo: :{:params}',
    'min_length' => [
        'countable' => 'El campo {:attr} debe tener al menos {:param0} elementos.',
        'digits' => 'El campo {:attr} debe tener al menos {:param0} dígitos.',
        'string' => 'El campo {:attr} debe tener al menos {:param0} caracteres.'
    ],
    'min' => [
        'file' => 'El campo {:attr} debe ser al menos {:param0} .',
        'numeric' => 'El campo {:attr} debe ser al menos {:param0}.',
    ],
    'numeric' => 'El {:attr} debe ser un número.',
    'present' => 'El campo {:attr} debe estar presente.',
    'required' => 'El campo {:attr} es requerido.',
    'size' => [
        'file' => 'El campo {:attr} debe ser {:param0} .',
        'numeric' => 'El campo {:attr} debe ser {:param0}.',
    ],
    'string' => 'El campo {:attr} debe ser una cadena.',
    'url' => 'El campo {:attr} debe ser una URL válida.'
];