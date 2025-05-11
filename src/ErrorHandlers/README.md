# Input Validation PHP Package

A simple and flexible PHP input validation module that helps you validate data and file uploads using a clean, expressive syntax.

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Available Rules](#available-rules)
- [Custom Rules](#custom-rules)
- [Configuration](#configuration)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)

---

## Features

- Validate arrays, strings, numbers, dates, files, and more
- Over 30 built-in validation rules
- Custom rule registration via a simple registry
- Customizable error handlers
- PSR-4 autoloading and Composer-ready

## Requirements

- PHP 8.0 or higher
- [Composer](https://getcomposer.org/)

## Installation

Install via Composer:

```bash
composer require hpd/input-validat
```

Then include the autoloader in your project:

```php
require 'vendor/autoload.php';
```

## Usage

```php
use Hpd\Validatify\Validator;

// Your input data (e.g., from $_POST, $_FILES)
data = [
    'email'    => 'user@example.com',
    'age'      => 25,
    'profile'  => [ 'tmp_name' => '/path/to/tmp', 'error' => UPLOAD_ERR_OK ],
];

// Validation rules
$rules = [
    'email'   => 'required|email',
    'age'     => 'numeric|minLength:2',
    'profile' => 'required|file|mimes:jpg,png|maxSize:2MB',
];

$validator = new Validator($data, $rules);

if (!$validator->validate()) {
    // Retrieve validation errors
    $errors = $validator->getErrors();
    print_r($errors);
} else {
    echo "Validation passed!";
}
```

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
| `url`           | Valid URL                                                      |
| `date`          | Valid date string (YYYY-MM-DD)                                  |
| `minLength`     | Minimum string length (e.g., `minLength:5`)                     |
| `minSize`       | Minimum file size (e.g., `minSize:1MB`) or numeric value        |
| `maxSize`       | Maximum file size (e.g., `maxSize:2MB`) or numeric value        |
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

You can register custom rules at runtime using the `RuleRegistry`:

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

## Configuration

The package can optionally load settings from an INI file using the `Configuration` singleton:

```php
use Hpd\Validatify\Configuration;

$config = Configuration::getInstance(__DIR__ . '/config/validation.ini');
$settings = $config->get('errorMessages');
```

Create a `config/validation.ini` file to store any global settings (e.g., custom error message templates).

## Testing

Run the test suite with PHPUnit:

```bash
composer install --dev
vendor/bin/phpunit
```

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request.

1. Fork it
2. Create your feature branch (`git checkout -b feature/my-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin feature/my-feature`)
5. Open a pull request

## License

This project does not include a license by default. Please add your preferred open-source license (e.g., MIT) in a `LICENSE` file.# Input Validation PHP Package

A simple and flexible PHP input validation module that helps you validate data and file uploads using a clean, expressive syntax.

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Available Rules](#available-rules)
- [Custom Rules](#custom-rules)
- [Configuration](#configuration)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)

---

## Features

- Validate arrays, strings, numbers, dates, files, and more
- Over 30 built-in validation rules
- Custom rule registration via a simple registry
- Customizable error handlers
- PSR-4 autoloading and Composer-ready

## Requirements

- PHP 8.0 or higher
- [Composer](https://getcomposer.org/)

## Installation

Install via Composer:

```bash
composer require hpd/input-validat
```

Then include the autoloader in your project:

```php
require 'vendor/autoload.php';
```

## Usage

```php
use Hpd\Validatify\Validator;

// Your input data (e.g., from $_POST, $_FILES)
data = [
    'email'    => 'user@example.com',
    'age'      => 25,
    'profile'  => [ 'tmp_name' => '/path/to/tmp', 'error' => UPLOAD_ERR_OK ],
];

// Validation rules
$rules = [
    'email'   => 'required|email',
    'age'     => 'numeric|minLength:2',
    'profile' => 'required|file|mimes:jpg,png|maxSize:2MB',
];

$validator = new Validator($data, $rules);

if (!$validator->validate()) {
    // Retrieve validation errors
    $errors = $validator->getErrors();
    print_r($errors);
} else {
    echo "Validation passed!";
}
```

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
| `url`           | Valid URL                                                      |
| `date`          | Valid date string (YYYY-MM-DD)                                  |
| `minLength`     | Minimum string length (e.g., `minLength:5`)                     |
| `minSize`       | Minimum file size (e.g., `minSize:1MB`) or numeric value        |
| `maxSize`       | Maximum file size (e.g., `maxSize:2MB`) or numeric value        |
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

You can register custom rules at runtime using the `RuleRegistry`:

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

## Configuration

The package can optionally load settings from an INI file using the `Configuration` singleton:

```php
use Hpd\Validatify\Configuration;

$config = Configuration::getInstance(__DIR__ . '/config/validation.ini');
$settings = $config->get('errorMessages');
```

Create a `config/validation.ini` file to store any global settings (e.g., custom error message templates).

## Testing

Run the test suite with PHPUnit:

```bash
composer install --dev
vendor/bin/phpunit
```

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request.

1. Fork it
2. Create your feature branch (`git checkout -b feature/my-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin feature/my-feature`)
5. Open a pull request

## License

This project does not include a license by default. Please add your preferred open-source license (e.g., MIT) in a `LICENSE` file.