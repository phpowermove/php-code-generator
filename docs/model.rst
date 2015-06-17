Model
=====

Create Models programmatically
------------------------------

You can create models with the provided fluent API. These models are available:

* ``PhpClass``
* ``PhpTrait``
* ``PhpInterface``
* ``PhpFunction``

The functionality is demonstrated for a ``PhpClass`` but also works accordingly for all the other types.

Create your first Class
^^^^^^^^^^^^^^^^^^^^^^^

Let's start with a simple example::

  <?php
  use gossi\codegen\model\PhpClass;

  $class = new PhpClass();
  $class->setQualifiedName('my\cool\Tool');

which will generate an empty::

  <?php
  namespace my\cool;

  class Tool {

  }


Adding a Constructor
^^^^^^^^^^^^^^^^^^^^

It's better to have a constructor, so we add one::

  <?php
  use gossi\codegen\model\PhpClass;
  use gossi\codegen\model\PhpMethod;
  use gossi\codegen\model\PhpParameter;

  $class = new PhpClass();
  $class
    ->setQualifiedName('my\cool\Tool')
    ->setMethod(PhpMethod::create('__construct')
      ->addParameter(PhpParameter::create('target')
        ->setType('string')
        ->setDescription('Creates my Tool')
      )
    );

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

We've just learned how to pass a blank method, the constructor to the class. We can also add `variables`, `constants` and of course `methods`. Let's do so::

  <?php
  use gossi\codegen\model\PhpClass;
  use gossi\codegen\model\PhpMethod;
  use gossi\codegen\model\PhpParameter;
  use gossi\codegen\model\PhpProperty;
  use gossi\codegen\model\PhpConstant;

  $class = new PhpClass();
  $class
    ->setName('my\cool\Tool')
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

When you put code inside a method there can be a reference to a class or interface, which you normally would put the qualified name into a use statement above your code. So here is how you do it::

  <?php
  use gossi\codegen\model\PhpClass;
  use gossi\codegen\model\PhpMethod;

  $class = new PhpClass();
  $class
    ->setQualifiedName('my\cool\Tool')
    ->setMethod(PhpMethod::create('__construct')
      ->setBody('$request = Request::createFromGlobals();')
    )
    ->declareUse('Symfony\\Component\\HttpFoundation\\Request');

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

Create Models through Reflection
--------------------------------

If you want to modify existing code, the best way to do this is through reflection. Just like the following::

  <?php
  use gossi\codegen\model\PhpClass;

  $class = PhpClass::fromReflection(new \ReflectionClass('MyClass'));

Make sure ``MyClass`` is loaded.
