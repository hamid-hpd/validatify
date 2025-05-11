<?php
return[
    'accepted' => 'The {:attr} field must be accepted.',
    'after' => 'The {:attr} must be a date after {:param0}.',
    'after_equal' => 'The {:attr} must be a date after or equal to {:param0}.',
    'alpha' => 'The {:attr} field must only contain letters.',
    'alpha_dash' => 'The {:attr} field may only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The {:attr} field may only contain letters and numbers.',
    'alpha_space' => 'The {:attr} field may only contain letters and spaces.',
    'array' => 'The {:attr} field must be an array.',
    'before'=> 'The {:attr} field must be a date before {:param0}.',
    'before_equal' => 'The {:attr} must be a date before or equal to {:param0}.',
    'boolean' => 'The {:attr} field can only be true or false.',
    'date' => 'The {:attr} field must be a valid date.',
    'default' => 'The {:attr} field is not valid.',
    'email' => 'The {:attr} field must be a valid email address.',
    'extensions' => 'The {:attr} field must have one of the following extensions: {:params}',
    'file' => 'The {:attr} field must be a file.' ,
    'image' => 'The {:attr} must be an image.',
    'integer' => 'The {:attr} field must be an integer.',
    'ip' => 'The {:attr} field must be a valid IP address',
    'length' => [
        'countable' => 'The {:attr} field must contain {:param0} items.',
        'digits' => 'The {:attr} field must be {:param0} digits.',
        'string' => 'The {:attr} field must be {:param0} characters.',       
    ],
    'max_length' => [
        'countable' => 'The {:attr} field must not have more than {:param0} items.',
        'digits' => 'The {:attr} field must not have more than {:param0} digits.',
        'string' => 'The {:attr} field must be at most {:param0} characters long.'
    ],
    'max' => [
        'file' => 'The {:attr} field must not be greater than {:param0} .',
        'numeric' => 'The {:attr} field must not be greater than {:param0} .',
    ],
    'mimes' => 'The {:attr} field must be a file of type: {:params} .',
    'mime_types' => 'The {:attr} field must be a file of type: :{:params} .',
    'min_length' => [
        'countable' => 'The {:attr} field must have at least {:param0} items.',
        'digits' => 'The {:attr} field must have at least {:param0} digits.',
        'string' => 'The {:attr} field must be at least {:param0} characters long.'
    ],
    'min' => [
        'file' => 'The {:attr} field must be at least {:param0} .',
        'numeric' => 'The {:attr} field must be at least {:param0} .',
    ],
    'numeric' => 'The {:attr} must be a number.',
    'present' => 'The {:attr} field must be present.',
    'required' => 'The {:attr} field is required.',
    'size' => [
        'file' => 'The {:attr} must be {:param0} .',
        'numeric' => 'The {:attr} field must be {:param0} .',
    ],
    'string' => 'The {:attr} field must be a string.',
    'unique' => 'The {:attr} has already been taken.',
    'url' => 'The {:attr} field must be a valid URL.'
];