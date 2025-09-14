<p align="center">
    <img src="assets/validatify.png" width="250px" height="105px">
</p>

# VALIDATIFY
A simple and flexible PHP input validation library that helps you validate data and file uploads using a clean, expressive syntax.

## Table of Contents

- [Introduction](#php-inout-validator-module)
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
  - [String Syntax](#1-string-syntax)
  - [Array Syntax](#2-array-syntax)
  - [Wildcard Syntax](#3-wildcard-syntax)
- [Validator Class](#validator-class)
- [Stop on First Failure](#stoponfirstfailure)
- [Halt Validation](#halt-validation)
- [Available Rules](#available-rules)
- [Custom Rules](#custom-rules)
  - [Custom Error Handlers](#custom-error-handlers)
  - [Dependencies Injection](#dependencies-injection)
- [Configuration](#configuration)
- [Localization](#localization)
- [Testing](#testing)
- [Donate](#donate)
- [License](#license)
- [Other Proiects](#check-out-my-other-projects)
---

## Features

- Validate arrays, strings, numbers, dates, files, and more
- Over 30 built-in validation rules
- Custom rule registration via a simple registry
- Customizable error handlers
- Customize error messages
- PSR-4 autoloading and Composer-ready

## Requirements

- PHP 8.0 or higher
- [Composer](https://getcomposer.org/)

## Installation

Install via Composer:

```cmd
composer require hpd/validatify
```

Then include the autoloader in your project:

```php
require_once 'vendor/autoload.php';
```
Note: You only need to include the autoloader once.
If you are already using a framework like Laravel, Symfony, or Slim, you can skip this step because the framework loads the Composer autoloader for you.

## Usage

You can define validation rules for each field either as a **pipe-delimited string** or as an **array** of rule names (with optional parameters).

### 1. String Syntax
Use a single string where individual rules are separated by `|`. Parameters for a rule follow a colon `:`.

```php
use Hpd\Validatify\Validator;

$data = [
    'email'    => 'user@example.com',
    'password' => 'secret123',
    'file'     => $_FILE['file']
];

// Rules defined as a string
$rules = [
    'email'    => 'required|email',            // required and must be a valid email
    'password' => 'required|minLength:8',      // required and minimum length of 8 characters
    'file'     => 'required|file|mimes:jpg,png|max:2MB', // required file upload rules
];

$validator = new Validator($data, $rules);
if (!$validator->validate()) {
    print_r($validator->getErrors());
} else {
    echo "Validation passed!";
}
```

> **Tip:** To validate a range of lengths or sizes, chain `minLength`/`min` and `maxLength`/`max` rules, e.g., `minLength:5|maxLength:10` or `min:1MB|max:2MB`.

### 2. Array Syntax
Use an array of rule strings rather than a pipe‑delimited string. Each element in the array is a rule name or a rule with parameter(s) separated by a colon `:`.

```php
use Hpd\Validatify\Validator;

$data = [
    'age'      => 30,
    'username' => 'john_doe',
];

// Rules defined as an array of strings
$rules = [
    'age'      => ['required', 'numeric'],                   // same as 'required|numeric'
    'username' => ['required', 'minLength:3', 'maxLength:15'], // range of lengths
];

$validator = new Validator($data, $rules, $messages = []);
if (!$validator->validate()) {
    print_r($validator->getErrors());
} else {
    echo "Validation passed!";
}
```

### 3. Wildcard Syntax
You can apply rules to each element in an array by using the `*` wildcard in your field keys. This is useful for validating arrays of objects or simple lists.

```php
use Hpd\Validatify\Validator;

data = [
    'users' => [
        ['email' => 'joe@example.com'],
        ['email' => 'invalid-email'],
    ],
    'scores' => [100, 87, 'bad'],
];

$rules = [
    'users.*.email' => 'required|email',  // Validate email for each user
    'scores.*'      => 'numeric|min:0|max:100',  // Validate each score is a number
];

$validator = new Validator($data, $rules);
if (!$validator->validate()) {
    print_r($validator->getErrors());
} else {
    echo "All items validated!";
}
```

## Validator Class 

The core **`Validator`** class provides the following constructor and methods:

```php
public function __construct(array $data, array $rules, array $messages = [])
```
- **`$data`**: Associative array of input values (e.g., `$_POST`, `$_FILES`).
- **`$rules`**: Validation rules defined per field (string or array syntax).
- **`$messages`** (optional): Custom error messages mapped by field and rule, e.g.:
  ```php
  $messages=
  [
    'email.required' => 'We need to know your email address!',
    'password.minLength' => 'Password must be at least :param characters long.'
  ]

  $validator = new Validator($data, $rules,$messages);
  ```

```php
public function validate(): bool
```
- Runs all rules against the data. Returns `true` if validation passes, or `false` if any rule fails.
```php
public function getErrors(): array
```
- Returns an associative array of error messages indexed by field name and rule, e.g.:
  ```php
  [
    'email' => ['required' => 'Email is required.'],
    'password' => ['minLength' => 'Password must be at least 8 characters.']
  ]
  ```

```php
public function stopOnFirstFailure(bool $value): void
```
- Accepts a boolean parameter (`true` or `false`) to enable or disable stopping on the first validation failure.
- Call this method before running the `validate()` method to configure the behavior.

### StopOnFirstFailure

The `stopOnFirstFailure` method tells the validator to Stop validation for all attributes after encountering the first failure.". This can be useful when you want to optimize performance or avoid processing unnecessary rules after a failure.

#### Usage

To enable this feature, call the `stopOnFirstFailure` method with `true`:

```php
use Hpd\Validatify\Validator;

$data = [
    'email' => 'invalid-email',
    'password' => 'short',
];

$rules = [
    'email' => 'required|email',
    'password' => 'required|minLength:8',
];

$validator = new Validator($data, $rules);

// Enable stop on first failure
$validator->stopOnFirstFailure(true);

if (!$validator->validate()) {
    print_r($validator->getErrors());
}
```

In this example, the validation will stop as soon as the first failure (invalid email) is encountered, and the password rule will not be processed.


### Halt Validation

The `halt` mechanism allows you to stop running validation rules for the field after the first validation failure. Validation for other fields will continue as usual.

#### Usage

To enable this feature, include the `halt` rule in the validation rules for a specific field:

```php
use Hpd\Validatify\Validator;

$data = [
    'email' => 'invalid-email',
    'password' => 'short',
    'age' => 17,
];

$rules = [
    'email' => 'halt|required|email',          // Stop further rules for 'email' if it fails
    'password' => 'halt|required|minLength:8', // Stop further rules for 'password' if it fails
    'age' => 'required|numeric|min:18',       // Continue validating 'age' even if others fail
];

$validator = new Validator($data, $rules);

if (!$validator->validate()) {
    print_r($validator->getErrors());
}
```

#### How It Works

- If the `halt` rule is included for a field, validation for that field will stop as soon as the first error is encountered.
- Validation will continue for other fields, even if one field fails.

This feature is useful when you want to optimize validation by skipping unnecessary checks for fields that already have errors.

## Available Rules

| Rule Name       | Description                                                     |
|-----------------|-----------------------------------------------------------------|
| `required`      | Field must exist and not be empty                               |
| `present`       | Field must exist (can be empty)                                 |
| `numeric`       | Value must be numeric                                           |
| `boolean`       | Value must be boolean (`true`/`false`)                          |
| `string`        | Value must be a string                                          |
| `array`         | Value must be an array                                          |
| `alpha`         | Only alphabetic characters                                      |
| `alphaNum`      | Alphanumeric characters                                         |
| `alphaDash`     | Letters, numbers, dashes, and underscores                       |
| `alphaSpace`    | Letters and spaces                                              |
| `email`         | Valid email address                                             |
| `url`           | Valid URL                                                       |
| `date`          | Valid date string (YYYY-MM-DD)                                  |
| `minLength`     | Minimum string length (e.g., `minLength:5`)                     |
| `min`           | Minimum file size (e.g., `min:1MB`) or numeric value            |
| `max`           | Maximum file size (e.g., `max:2MB`) or numeric value            |
| `size`          | Exact size match for file or numeric value                      |
| `extensions`    | Allowed file extensions (e.g., `extensions:jpg,png`)            |
| `mimes`         | Allowed MIME types (e.g., `mimes:image/jpeg,image/png`)         |
| `mimeTypes`     | Allowed MIME types (alias of `mimes`)                           |
| `before`        | Date is before given date (e.g., `before:2025-01-01`)           |
| `beforeEqual`   | Date is before or equal (e.g., `beforeEqual:2025-01-01`)        |
| `after`         | Date is after given date (e.g., `after:2020-01-01`)             |
| `afterEqual`    | Date is after or equal (e.g., `afterEqual:2020-01-01`)          |
| `unique`        | Value must be unique within an array                            |

> **Note:** To see the full list of rules, check the `src/Rules` directory.

## Custom Rules

You can register custom rules at runtime using the `RuleRegistry::register`:
```php
    public static function register(string $ruleName, callable $callback, string $errorHandlerName = 'default'): void
```

```php
use Hpd\Validatify\Rules\RuleRegistry;

// Register a new rule named "odd"
RuleRegistry::register('odd', function($value, $params) {
    return is_numeric($value) && ($value % 2 === 1);
});

// Use your custom rule
$rules = [
    'id' => 'required|odd'
];

```
### Custom Error Handlers
By default, custom rules use the default error handler, formatting messages via your locale files. To supply a specific error handler, register your rule with a handler name:
```php
RuleRegistry::register('odd', function($value, $params) {
    return is_numeric($value) && ($value % 2 === 1);
},'integer');
```

## Dependencies Injection
Often custom rules or regular rules require external services (e.g., a database connection). Use the Dependency container to set and retrieve dependencies by rule name:
```php
use Hpd\Validatify\Rules\RuleRegistry;
use Hpd\Validatify\Dependency;

RuleRegistry::register('user_exist', function ($value, $parameters, $dependencies) {
    $dbConnection = $dependencies['dbConnection'];
    $stmt = $dbConnection->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $stmt->execute(['email' => $value]);
    return $stmt->fetchColumn() == 1;
}); 


// Attach dependencies to the 'user_exist' rule
$conn = new PDO("mysql:host=localhost;dbname=mydb", 'root', '');

Dependency::set('user_exist',['dbConnection'=>$conn]);
```

## Configuration

Modify default settings in config/config.ini:
The package can optionally load settings from an INI file using the `Configuration` singleton:
```ini
; Default language for error messages
language = en

; Default timezone for date comparisons
; timezone = UTC

; Enable debug mode (true/false)
; debug_mode = false
```
## Localization

Error messages are stored in `Languages/{lang}.php.` Supported languages:

* Arabic (ar)

* German (de)

* English (en)

* Farsi (fa)

* French (fr)

* Spanish (sp)

* Turkish (tr)

To add your own language, create a `{lang}.php` file in `Languages/` and set language in config.ini.

## Running Tests

The test files are **not** included in the distributed (dist) package, so to run them you need to fetch the source. You have two options:

1. **Clone the repository and run tests locally**  
   ```bash
   # 1. Clone the GitHub repo and install dependencies
   git clone https://github.com/hpd/validatify.git
   cd validatify
   composer install

   # 2. Run the test suite
   composer test

2. **Install via Packagist with source**
```bash
# Fetches the full source (including tests) into vendor/
composer require hpd/validatify --prefer-source

# Navigate into the package directory and run tests
cd vendor/hpd/validatify
composer install   # installs phpunit/phpunit from require-dev
composer test
```

## Donate

If you like this project and want to support it, feel free to send USDT donations to the addresses below. Thank you! 🙏

![Tether](https://img.shields.io/badge/Tether-blue?logo=tether&logoColor=white)
| Network | Address |
|---------|---------|
| ![Tether ERC20](https://img.shields.io/badge/USDT-ERC20-green?logo=tether) | `0x2bFcEcCF2f25d48CbdC05a9d55A46262a0A6E542` | 
| ![Tether TRC20](https://img.shields.io/badge/USTD-TRC20-red?logo=tether)    | `TEHzXzg4nMp7MW5pVH6fGmuq7JBaFovMW3` | 

Your support allows me to continue maintaining and improving this project. Thank you so much for your contribution! 🙏


## License

This project is licensed under the [MIT License](./LICENSE).

## Check Out My Other Projects

Hey! If you liked this package, you might enjoy some of my other work too:

- [Laravel CAPTCHA](https://github.com/hamid-hpd/captcha.git) – Lightweight Laravel CAPTCHA Package Supporting Version 8 and Above with Session and Stateless Modes.
- [jQuery Confirmation Dialog](https://github.com/hamid-hpd/jquery-confirm-dialog.git) – Customizable jQuery Confirmation Dialog Plugin with RTL and Theming Support

I'm always building and sharing new stuff — feel free to take a look, star ⭐ what you like, or even open a PR!
