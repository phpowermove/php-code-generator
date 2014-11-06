# PHP Code Generator

[![Build Status](https://travis-ci.org/gossi/php-code-generator.svg?branch=master)](https://travis-ci.org/gossi/php-code-generator)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gossi/php-code-generator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gossi/php-code-generator/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/gossi/php-code-generator/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/gossi/php-code-generator/?branch=master)

This library provides some tools that you commonly need for generating PHP code.

## Installation

Install via Composer:

```json
{
	"require": {
		"gossi/php-code-generator": "~1"
	}
}

## Usage

There are two things you need to generate code.

1. A generator
	* CodeGenerator
	* CodeFileGenerator
2. A model to generate
	* PhpClass
	* PhpInterface
	* PhpTrait
	* PhpFunction
	
You can create these models and push all the data using a fluent API or read from existing code through reflection.

### Generate Code

a) Simple:

```php
use gossi\codegen\generator\CodeGenerator;
use gossi\codegen\model\PhpClass;
use gossi\codegen\model\PhpMethod;
use gossi\codegen\model\PhpParameter;

$class = new PhpClass();
$class->setName('my\cool\Tool');
	->setMethod(PhpMethod::create('__construct')
		->addParameter(PhpParameter::create('target')
			->setType('string')
			->setDescription('Creates my Tool')
		)
	);	

$generator = new CodeGenerator();
$code = $generator->generate($class);
```

b) From Reflection:

```php
use gossi\codegen\generator\CodeGenerator;
use gossi\codegen\model\PhpClass;

$class = PhpClass::fromReflection(new \ReflectionClass('MyClass'));

$generator = new CodeGenerator();
$code = $generator->generate($class);
```

### Code Generators

**CodeGenerator**

Creates code for a given model

| Key | Type | Default Value | Description |
| --- | ---- | ------------- | ----------- |
| generateDocblock | boolean | true | enables docblock generation prior to code generation |
| generateEmptyDocblock | boolean | true | when docblock generation is enabled, even empty docblocks will be generated |

**CodeFileGenerator**

Creates a complete php file with the given model inside.

Same options as `CodeGenerator` plus:

| Key | Type | Default Value | Description |
| --- | ---- | ------------- | ----------- |
| headerComment | string | empty | A comment, that will be put after the <?php statement |
| headerDocblock | string\|Docblock | empty | A docblock that will be positioned after the possible header comment |
| blankLineAtEnd | boolean | true | Places an empty line at the end of the generated file |

## Contributing

Feel free to fork and submit a pull request (don't forget the tests) and I am happy to merge.


## References

- This project is a spin-off of the older [schmittjoh/cg-library](https://github.com/schmittjoh/cg-library) library.
