Generator
=========

The package ships with two generators, which are configurable through an associative array as constructor parameter. Alternatively if you have a project that uses the same configuration over and over again, extend the respective config object and pass it instead of the configuration array.

::

  <?php
  use phpowermove\codegen\generator\CodeGenerator;

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

* Class: ``phpowermove\codegen\generator\CodeGenerator``
* Config: ``phpowermove\codegen\config\CodeGeneratorConfig``
* Options:

  +-------------------------+-----------------------------------+---------------+-------------------------------------------------------------------------+
  | Key                     | Type                              | Default Value | Description                                                             |
  +=========================+===================================+===============+=========================================================================+
  | generateDocblock        | boolean                           | true          | enables docblock generation prior to code generation                    |
  +-------------------------+-----------------------------------+---------------+-------------------------------------------------------------------------+
  | generateEmptyDocblock   | boolean                           | true          | allows generation of empty docblocks                                    |
  +-------------------------+-----------------------------------+---------------+-------------------------------------------------------------------------+
  | generateScalarTypeHints | boolean                           | false         | generates scalar type hints, e.g. in method/function parameters (PHP 7) |
  +-------------------------+-----------------------------------+---------------+-------------------------------------------------------------------------+
  | generateReturnTypeHints | boolean                           | false         | generates scalar type hints for return values (PHP 7)                   |
  +-------------------------+-----------------------------------+---------------+-------------------------------------------------------------------------+
  | enableSorting           | boolean                           | true          | Enables sorting                                                         |
  +-------------------------+-----------------------------------+---------------+-------------------------------------------------------------------------+
  | useStatementSorting     | boolean|string|Closure|Comparator | default       | Sorting mechanism for use statements                                    |
  +-------------------------+-----------------------------------+---------------+-------------------------------------------------------------------------+
  | constantSorting         | boolean|string|Closure|Comparator | default       | Sorting mechanism for constants                                         |
  +-------------------------+-----------------------------------+---------------+-------------------------------------------------------------------------+
  | propertySorting         | boolean|string|Closure|Comparator | default       | Sorting mechanism for properties                                        |
  +-------------------------+-----------------------------------+---------------+-------------------------------------------------------------------------+
  | methodSorting           | boolean|string|Closure|Comparator | default       | Sorting mechanism for methods                                           |
  +-------------------------+-----------------------------------+---------------+-------------------------------------------------------------------------+

  **Note**: when ``generateDocblock`` is set to ``false`` then ``generateEmptyDocblock`` is ``false`` as well.

  **Note 2**: For sorting ...

  * ... a string will used to find a comparator with that name (at the moment there is only default).
  * ... with a boolean you can disable sorting for a particular member
  * ... you can pass in your own ``\Closure`` for comparison
  * ... you can pass in a Comparator_ for comparison

.. _Comparator: https://phootwork.github.io/lang/comparison/

* Example:

  ::

    <?php
    use phpowermove\codegen\generator\CodeGenerator;

    // will set every option to true, because of the defaults
    $generator = new CodeGenerator([
      'generateScalarTypeHints' => true,
      'generateReturnTypeHints' => true
    ]);
    $code = $generator->generate($myClass);

CodeFileGenerator
-----------------

Generates a complete php file with the given model inside. Especially useful when creating PSR-4 compliant code, which you are about to dump into a file. It extends the ``CodeGenerator`` and as such inherits all its benefits.

* Class: ``phpowermove\codegen\generator\CodeFileGenerator``
* Config: ``phpowermove\codegen\config\CodeFileGeneratorConfig``
* Options: Same options as ``CodeGenerator`` plus:

  +--------------------+----------------------+---------------+----------------------------------------------------------------------------------------+
  | Key                | Type                 | Default Value | Description                                                                            |
  +====================+======================+===============+========================================================================================+
  | headerComment      | null|string|Docblock | null          | A comment, that will be put after the ``<?php`` statement                              |
  +--------------------+----------------------+---------------+----------------------------------------------------------------------------------------+
  | headerDocblock     | null|string|Docblock | null          | A docblock that will be positioned after the possible header comment                   |
  +--------------------+----------------------+---------------+----------------------------------------------------------------------------------------+
  | blankLineAtEnd     | boolean              | true          | Places an empty line at the end of the generated file                                  |
  +--------------------+----------------------+---------------+----------------------------------------------------------------------------------------+
  | declareStrictTypes | boolean              | false         | Whether or not a ``declare(strict_types=1);`` is placed at the top of the file (PHP 7) |
  +--------------------+----------------------+---------------+----------------------------------------------------------------------------------------+

  **Note**: ``declareStrictTypes`` sets ``generateScalarTypeHints`` and ``generateReturnTypeHints`` to ``true``.

* Example:

  ::

    <?php
    use phpowermove\codegen\generator\CodeFileGenerator;

    $generator = new CodeGenerator([
      'headerComment' => 'This will be placed at the top, woo',
      'headerDocblock' => 'Full documentation mode confirmed!',
      'declareStrictTypes' => true
    ]);
    $code = $generator->generate($myClass);
