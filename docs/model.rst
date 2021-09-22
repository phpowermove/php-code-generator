Model
=====

A model is a representation of your code, that you either read or create.

Model Overview
--------------

There are different types of models available which are explained in this section.

Structured Models
^^^^^^^^^^^^^^^^^

Structured models are composites and can contain other models, these are:

* ``PhpClass``
* ``PhpTrait``
* ``PhpInterface``

Generateable Models
^^^^^^^^^^^^^^^^^^^

There is only a couple of models available which can be passed to a generator. These are the mentioned structured models + ``PhpFunction``.

Part Models
^^^^^^^^^^^

Structured models can be composed of various members. And functions and methods can itself contain zero to many parameters. All parts are:

* ``PhpConstant``
* ``PhpProperty``
* ``PhpMethod``
* ``PhpParameter``

Name vs. Namespace vs. Qualified Name ?
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

There can be a little struggle about the different names, which are `name`, `namespace` and `qualified name`. Every model has a name and generateable models additionally have a namespace and qualified name. The qualified name is a combination of namespace + name. Here is an overview:

+--------------------+----------------+
| **Name**           | Tool           |
+--------------------+----------------+
| **Namespace**      | my\\cool       |
+--------------------+----------------+
| **Qualified Name** | my\\cool\\Tool |
+--------------------+----------------+

Create Models programmatically
------------------------------

You can create models with the provided fluent API. The functionality is demonstrated for a ``PhpClass`` but also works accordingly for all the other generateable models.

Create your first Class
^^^^^^^^^^^^^^^^^^^^^^^

Let's start with a simple example::

  <?php
  use phpowermove\codegen\model\PhpClass;

  $class = new PhpClass();
  $class->setQualifiedName('my\\cool\\Tool');

which will generate an empty::

  <?php
  namespace my\cool;

  class Tool {

  }


Adding a Constructor
^^^^^^^^^^^^^^^^^^^^

It's better to have a constructor, so we add one::

  <?php
  use phpowermove\codegen\model\PhpClass;
  use phpowermove\codegen\model\PhpMethod;
  use phpowermove\codegen\model\PhpParameter;

  $class = new PhpClass('my\\cool\\Tool');
  $class
      ->setMethod(PhpMethod::create('__construct')
          ->addParameter(PhpParameter::create('target')
              ->setType('string')
              ->setDescription('Creates my Tool')
          )
      )
  ;

you can see the fluent API in action and the snippet above will generate::

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


Adding members
^^^^^^^^^^^^^^

We've just learned how to pass a blank method, the constructor to the class. We can also add `properties`, `constants` and of course `methods`. Let's do so::

  <?php
  use phpowermove\codegen\model\PhpClass;
  use phpowermove\codegen\model\PhpMethod;
  use phpowermove\codegen\model\PhpParameter;
  use phpowermove\codegen\model\PhpProperty;
  use phpowermove\codegen\model\PhpConstant;

  $class = PhpClass::create('my\\cool\\Tool')
      ->setMethod(PhpMethod::create('setDriver')
          ->addParameter(PhpParameter::create('driver')
              ->setType('string')
          )
          ->setBody('$this->driver = $driver');
      )
      ->setProperty(PhpProperty::create('driver')
          ->setVisibility('private')
          ->setType('string')
      )
      ->setConstant(new PhpConstant('FOO', 'bar'))
  ;

will generate::

  <?php
  namespace my\cool;

  class Tool {

      /**
       */
      const FOO = 'bar';

      /**
       * @var string
       */
      private $driver;

      /**
       *
       * @param $driver string
       */
      public function setDriver($driver) {
          $this->driver = $driver;
      }
  }


Declare use statements
^^^^^^^^^^^^^^^^^^^^^^

When you put code inside a method there can be a reference to a class or interface, where you normally put the qualified name into a use statement. So here is how you do it::

  <?php
  use phpowermove\codegen\model\PhpClass;
  use phpowermove\codegen\model\PhpMethod;

  $class = new PhpClass();
  $class
      ->setName('Tool')
      ->setNamespace('my\\cool')
      ->setMethod(PhpMethod::create('__construct')
          ->setBody('$request = Request::createFromGlobals();')
      )
      ->declareUse('Symfony\\Component\\HttpFoundation\\Request')
  ;

which will create::

  <?php
  namespace my\cool;

  use Symfony\Component\HttpFoundation\Request;

  class Tool {

      /**
       */
      public function __construct() {
          $request = Request::createFromGlobals();
      }
  }

Much, much more
^^^^^^^^^^^^^^^

The API has a lot more to offer and has almost full support for what you would expect to manipulate on each model, of course everything is fluent API.

Create from existing Models
---------------------------

You can also read a model from existing code. Reading from a file is probably the best option here. It will parse the file and fill up the model. Alternatively if you do have the class already loaded you can use reflection to load the model.

From File
^^^^^^^^^

Reading from a file is the simplest way to read existing code, just like this::

  <?php
  use phpowermove\codegen\model\PhpClass;

  $class = PhpClass::fromFile('path/to/MyClass.php');


Through Reflection
^^^^^^^^^^^^^^^^^^

If you already have your class loaded, then you can use reflection to load your code::

  <?php
  use phpowermove\codegen\model\PhpClass;

  $reflection = new \ReflectionClass('MyClass');
  $class = PhpClass::fromReflection($reflection->getFileName());

Also reflection is nice, there is a catch to it. You must make sure ``MyClass`` is loaded. Also all the requirements (use statements, etc.) are loaded as well, anyway you will get an error when initializing the the reflection object.

Understanding Values
--------------------

The models ``PhpConstant``, ``PhpParameter`` and  ``PhpProperty`` support values; all of them implement the ``ValueInterface``. Though, there is a difference between values and expressions. Values refer to language primitives (``string``, ``int``, ``float``, ``bool`` and ``null``). Additionally you can set a ``PhpConstant`` as value (the lib understands this as a library primitive ;-). If you want more complex control over the output, you can set an expression instead, which will be generated as is.

Some Examples::

  <?php
  PhpProperty::create('foo')->setValue('hello world.');
  // $foo = 'hello world.';

  PhpProperty::create('foo')->setValue(300);
  // $foo = 300;

  PhpProperty::create('foo')->setValue(3.14);
  // $foo = 3.14;

  PhpProperty::create('foo')->setValue(false);
  // $foo = false;

  PhpProperty::create('foo')->setValue(null);
  // $foo = null;

  PhpProperty::create('foo')->setValue(PhpConstant::create('BAR'));
  // $foo = BAR;

  PhpProperty::create('foo')->setExpression('self::MY_CONST');
  // $foo = self::MY_CONST;

  PhpProperty::create('foo')->setExpression("['my' => 'array']");
  // $foo = ['my' => 'array'];

For retrieving values there is a ``hasValue()`` method which returns ``true`` whether there is a value or an expression present. To be sure what is present there is also an ``isExpression()`` method which you can use as a second check::

  <?php

  if ($prop->hasValue()) {
      if ($prop->isExpression()) {
          // do something with an expression
      } else {
          // do something with a value
      }
  }
