Generator
=========

The package ships with two generators, which are configurable through an associative array as constructor parameter. Alternatively if you have a project that uses the same configuration over and over again, extend the respective config object and pass it instead of the configuration array.

CodeGenerator
-------------

Generates code for a given model. Additionally (and by default), it will generate docblocks for all contained classes, methods, interfaces, etc. you have prior to generating the code.

* Class: ``gossi\codegen\generator\CodeGenerator``
* Config: ``gossi\codegen\config\CodeGeneratorConfig``
* Options:

  +-----------------------+---------+---------------+-----------------------------------------------------------------------------+
  | Key                   | Type    | Default Value | Description                                                                 |
  +=======================+=========+===============+=============================================================================+
  | generateDocblock      | boolean | true          | enables docblock generation prior to code generation                        |
  +-----------------------+---------+---------------+-----------------------------------------------------------------------------+
  | generateEmptyDocblock | boolean | true          | when docblock generation is enabled, even empty docblocks will be generated |
  +-----------------------+---------+---------------+-----------------------------------------------------------------------------+

CodeFileGenerator
-----------------

Generates a complete php file with the given model inside. Especially useful when creating PSR-4 compliant code, which you are about to dump into a file. It extends the ``CodeGenerator`` and as such inherits all its benefits.

* Class: ``gossi\codegen\generator\CodeFileGenerator``
* Config: ``gossi\codegen\config\CodeFileGeneratorConfig``
* Options: Same options as ``CodeGenerator`` plus:

  +----------------+-----------------+---------------+----------------------------------------------------------------------+
  | Key            | Type            | Default Value | Description                                                          |
  +================+=================+===============+======================================================================+
  | headerComment  | string          | empty         | A comment, that will be put after the ``<?php`` statement            |
  +----------------+-----------------+---------------+----------------------------------------------------------------------+
  | headerDocblock | string|Docblock | empty         | A docblock that will be positioned after the possible header comment |
  +----------------+-----------------+---------------+----------------------------------------------------------------------+
  | blankLineAtEnd | boolean         | true          | Places an empty line at the end of the generated file                |
  +----------------+-----------------+---------------+----------------------------------------------------------------------+
