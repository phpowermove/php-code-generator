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
	use phpowermove\codegen\generator\CodeGenerator;
	use phpowermove\codegen\model\PhpClass;
	use phpowermove\codegen\model\PhpMethod;
	use phpowermove\codegen\model\PhpParameter;

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
	use phpowermove\codegen\generator\CodeGenerator;
	use phpowermove\codegen\model\PhpClass;

	$class = PhpClass::fromFile('path/to/class.php');

	$generator = new CodeGenerator();
	$code = $generator->generate($class);


c) From Reflection:

  ::

	<?php
	use phpowermove\codegen\generator\CodeGenerator;
	use phpowermove\codegen\model\PhpClass;

    $reflection = new \ReflectionClass('MyClass');
	$class = PhpClass::fromReflection($reflection->getFileName());

	$generator = new CodeGenerator();
	$code = $generator->generate($class);
