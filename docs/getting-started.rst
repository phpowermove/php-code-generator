Getting Started
===============

There are two things you need to generate code.

1. A :doc:`model` that contains the code structure
	* PhpClass
	* PhpInterface
	* PhpTrait
	* PhpFunction
2. A :doc:`generator`
	* CodeGenerator
	* CodeFileGenerator

You can create these models and push all the data using a fluent API or read from existing code through reflection. Here are two examples for each of those.

Generate Code
-------------

a) Simple:

  ::

	<?php
	use gossi\codegen\generator\CodeGenerator;
	use gossi\codegen\model\PhpClass;
	use gossi\codegen\model\PhpMethod;
	use gossi\codegen\model\PhpParameter;

	$class = new PhpClass();
	$class
	    ->setQualifiedName('my\\cool\\Tool')
	    ->setMethod(PhpMethod::create('__construct')
	        ->addParameter(PhpParameter::create('target')
	            ->setType('string')
	            ->setDescription('Creates my Tool')
	        )
	    )
	;

	$generator = new CodeGenerator();
	$code = $generator->generate($class);

  will generate:

  ::

	<?php
	namespace my\cool;

	class Tool {

	    /**
	     *
	     * @param $target string Creates my Tool
	     */
	    public function __construct($target) {
	    }
	}

b) From File:

  ::

	<?php
	use gossi\codegen\generator\CodeGenerator;
	use gossi\codegen\model\PhpClass;

	$class = PhpClass::fromFile('path/to/class.php');

	$generator = new CodeGenerator();
	$code = $generator->generate($class);


c) From Reflection:

  ::

	<?php
	use gossi\codegen\generator\CodeGenerator;
	use gossi\codegen\model\PhpClass;

    $reflection = new \ReflectionClass('MyClass');
	$class = PhpClass::fromReflection($reflection->getFileName());

	$generator = new CodeGenerator();
	$code = $generator->generate($class);
