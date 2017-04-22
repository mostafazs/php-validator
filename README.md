# PHP Validator

PHP form input validator.support validating common form input types,validate input from `$_POST` or any array.



## Installation

Require the package in `composer.json`

```json
"require": {
    "mostafazs/php-validator": "1.*"
},
```

If you are using Laravel, add an alias in `config/app.php`

```php
'aliases' => array(

    'App'             => 'Illuminate\Support\Facades\App',
    ...
    'View'            => 'Illuminate\Support\Facades\View',

    'Validator'      => 'mostafazs\php-validator',

),
```

## Usage

### Check empty input

````php
$result = Validator::filledIn($input);
var_dump($result);
````

### Check length of input

```php
$result = Validator::length($input,$operator,$length);
var_dump($result);
````
takes `<`,`>`,`=`,`>=`,`<=` as `$operator` argument


### Validate email address

```php
$result = Validator::email($email);
var_dump($result);
````

### Check equality of two input.

```php
$result = Validator::compase($einput1,$input2,caseSensitive);
var_dump($result);
````
sensitivity can be specified by adding `caseSensitive` to `true`

###  Check length of input to see is between tow value

```php
$result = Validator::lengthBetween($input,$min,$max,$inclusive);
var_dump($result);
````
inclusive can be specified by adding `$inclusive` to `true`

### Check an integer input against arguments.

```php
$result = Validator::value($input,$operator,$length);
var_dump($result);
````
`$operator` Takes <, >, =, <=, and >= and === as operators

### Validate just alphabetic character input

```php
$result = Validator::alpha($input);
var_dump($result);
````


### Validate alphanumeric character input

```php
$result = Validator::alphanumeric($input);
var_dump($result);
````

### Validate date by specified format

```php
$result = Validator::date($date,$format);
var_dump($result);
````
separators are "/" "." "-"<br/>
date formats "m" for month, "d" for day, "y" for year

### Validate url

```php
$result = Validator::Url($input);
var_dump($result);
````
