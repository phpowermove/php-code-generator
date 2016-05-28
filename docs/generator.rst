Generator
=========

The package ships with two generators, which are configurable through an associative array as constructor parameter. Alternatively if you have a project that uses the same configuration over and over again, extend the respective config object and pass it instead of the configuration array.

::

  <?php
  use gossi\codegen\generator\CodeGenerator;

  // a) new code generator with options passed as array
  $generator = new CodeGenerator([
    'generateDocblock' => false,
    ...
  ]);

  // b) new code generator with options passed as object
  $generator = new CodeGenerator(new MyCodeGenerationConfig());

CodeGenerator
-------------

Generates code for a given model. Additionally (and by default), it will generate docblocks for all contained classes, methods, interfaces, etc. you have prior to generating the code.

* Class: ``gossi\codegen\generator\CodeGenerator``
* Config: ``gossi\codegen\config\CodeGeneratorConfig``
* Options:

  +-------------------------+---------+---------------+-----------------------------------------------------------------------------+
  | Key                     | Type    | Default Value | Description                                                                 |
  +=========================+=========+===============+=============================================================================+
  | generateDocblock        | boolean | true          | enables docblock generation prior to code generation                        |
  +-------------------------+---------+---------------+-----------------------------------------------------------------------------+
  | generateEmptyDocblock   | boolean | true          | allows generation of empty docblocks                                        |
  +-------------------------+---------+---------------+-----------------------------------------------------------------------------+
  | generateScalarTypeHints | boolean | false         | generates scalar type hints, e.g. in method/function parameters (PHP 7)     |
  +-------------------------+---------+---------------+-----------------------------------------------------------------------------+
  | generateReturnTypeHints | boolean | false         | generates scalar type hints for return values (PHP 7)                       |
  +-------------------------+---------+---------------+-----------------------------------------------------------------------------+

  **Note**: when ``generateDocblock`` is set to ``false`` then ``generateEmptyDocblock`` is ``false` as well.

* Example:

  ::

    <?php
    use gossi\codegen\generator\CodeGenerator;

    // will set every option to true, because of the defaults
    $generator = new CodeGenerator([
      'generateScalarTypeHints' => true,
      'generateReturnTypeHints' => true
    ]);
    $code = $generator->generate($myClass);

CodeFileGenerator
-----------------

Generates a complete php file with the given model inside. Especially useful when creating PSR-4 compliant code, which you are about to dump into a file. It extends the ``CodeGenerator`` and as such inherits all its benefits.

* Class: ``gossi\codegen\generator\CodeFileGenerator``
* Config: ``gossi\codegen\config\CodeFileGeneratorConfig``
* Options: Same options as ``CodeGenerator`` plus:

  +--------------------+-----------------+---------------+----------------------------------------------------------------------------------------+
  | Key                | Type            | Default Value | Description                                                                            |
  +====================+=================+===============+========================================================================================+
  | headerComment      | string          | empty         | A comment, that will be put after the ``<?php`` statement                              |
  +--------------------+-----------------+---------------+----------------------------------------------------------------------------------------+
  | headerDocblock     | string|Docblock | empty         | A docblock that will be positioned after the possible header comment                   |
  +--------------------+-----------------+---------------+----------------------------------------------------------------------------------------+
  | blankLineAtEnd     | boolean         | true          | Places an empty line at the end of the generated file                                  |
  +--------------------+-----------------+---------------+----------------------------------------------------------------------------------------+
  | declareStrictTypes | boolean         | false         | Whether or not a ``declare(strict_types=1);`` is placed at the top of the file (PHP 7) |
  +--------------------+-----------------+---------------+----------------------------------------------------------------------------------------+

  **Note**: ``declareStrictTypes`` sets ``generateScalarTypeHints`` and ``generateReturnTypeHints`` to ``true``.

* Example:

  ::

    <?php
    use gossi\codegen\generator\CodeFileGenerator;

    $generator = new CodeGenerator([
      'headerComment' => 'This will be placed at the top, woo',
      'headerDocblock' => 'Full documentation mode confirmed!',
      'declareStrictTypes' => true
    ]);
    $code = $generator->generate($myClass);
