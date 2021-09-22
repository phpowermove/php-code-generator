<?php
namespace phpowermove\codegen\tests\model;

use phpowermove\codegen\model\PhpClass;
use phpowermove\codegen\model\PhpConstant;
use phpowermove\codegen\model\PhpFunction;
use phpowermove\codegen\model\PhpInterface;
use phpowermove\codegen\model\PhpMethod;
use phpowermove\codegen\model\PhpParameter;
use phpowermove\codegen\model\PhpProperty;
use phpowermove\codegen\model\PhpTrait;
use phpowermove\docblock\Docblock;
use phpowermove\docblock\tags\AuthorTag;
use phpowermove\docblock\tags\SeeTag;
use phpowermove\docblock\tags\ThrowsTag;
use PHPUnit\Framework\TestCase;

/**
 * @group model
 */
class DocblockTest extends TestCase {

	const METHOD = 'myMethod';

	const PROP = 'myProperty';

	const CONSTANT = 'MY_CONSTANT';

	/**
	 * @return PhpMethod
	 */
	private function getMethod() {
		return PhpMethod::create(self::METHOD)
			->setDescription('my method')
			->setLongDescription('my very long method')
			->setType('string', 'this method returns a string')
			->addParameter(PhpParameter::create('a')->setDescription('method-param'));
	}

	/**
	 * @return PhpProperty
	 */
	private function getProperty() {
		return PhpProperty::create(self::PROP)
			->setDescription('my prop')
			->setLongDescription('my very long prop')
			->setType('int', 'this prop is an integer');
	}

	/**
	 * @return PhpConstant
	 */
	private function getConstant() {
		return PhpConstant::create(self::CONSTANT)
			->setDescription('my constant')
			->setLongDescription('my very long contstant')
			->setType('boolean', 'this constant is a boolean');
	}

	public function testClass() {
		$class = new PhpClass();
		$class->setName('class-name')
			->setDescription('this is my class')
			->setLongDescription('this is my very long class')
			->setProperty($this->getProperty())
			->setMethod($this->getMethod())
			->setConstant($this->getConstant())
			->generateDocblock();

		$this->assertFalse($class->getDocblock()->isEmpty());
		$this->assertNotNull($class->getProperty(self::PROP)->getDocblock());
		$this->assertNotNull($class->getMethod(self::METHOD)->getDocblock());
		$this->assertNotNull($class->getConstant(self::CONSTANT)->getDocblock());

		$docblock = $class->getDocblock();
		$author = AuthorTag::create()->setName('phpowermove')->setEmail('iiih@mail.me');
		$docblock->appendTag($author);

		$this->assertTrue($docblock->hasTag('author'));

		$expected = '/**
 * this is my class
 *
 * this is my very long class
 *
 * @author phpowermove <iiih@mail.me>
 */';
		$this->assertEquals($expected, $docblock->toString());
	}

	public function testEmptyClass() {
		$class = new PhpClass();
		$class->generateDocblock();
		$this->assertTrue($class->getDocblock()->isEmpty());
	}

	public function testInterface() {
		$interface = new PhpInterface();
		$interface->setDescription('my interface')->setLongDescription('this is my very long description')->setConstant($this->getConstant())->setMethod($this->getMethod());
		$interface->generateDocblock();

		$this->assertFalse($interface->getDocblock()->isEmpty());
		$this->assertNotNull($interface->getMethod(self::METHOD)->getDocblock());
		$this->assertNotNull($interface->getConstant(self::CONSTANT)->getDocblock());
	}

	public function testEmptyInterface() {
		$interface = new PhpInterface();
		$interface->generateDocblock();
		$this->assertTrue($interface->getDocblock()->isEmpty());
	}

	public function testTrait() {
		$trait = new PhpTrait();
		$trait->setDescription('my trait')->setLongDescription('this is my very long description')->setProperty($this->getProperty())->setMethod($this->getMethod());
		$trait->generateDocblock();

		$this->assertFalse($trait->getDocblock()->isEmpty());
		$this->assertNotNull($trait->getProperty(self::PROP)->getDocblock());
		$this->assertNotNull($trait->getMethod(self::METHOD)->getDocblock());
	}

	public function testEmptyTrait() {
		$trait = new PhpTrait();
		$trait->generateDocblock();
		$this->assertTrue($trait->getDocblock()->isEmpty());
	}

	public function testFunction() {
		$function = PhpFunction::create(self::METHOD)->setType('string', 'this method returns a string')->addParameter(new PhpParameter('a'));
		$function->generateDocblock();
		$this->assertFalse($function->getDocblock()->isEmpty());
	}

	public function testEmptyFunction() {
		$function = new PhpFunction();
		$function->generateDocblock();
		$this->assertTrue($function->getDocblock()->isEmpty());
	}

	public function testConstant() {
		$expected = '/**
 * my constant
 *
 * my very long contstant
 *
 * @var boolean this constant is a boolean
 */';
		$constant = $this->getConstant();
		$constant->generateDocblock();

		$this->assertEquals($expected, '' . $constant->getDocblock()->toString());
	}

	public function testEmptyConstant() {
		$constant = new PhpConstant();
		$constant->generateDocblock();
		$this->assertTrue($constant->getDocblock()->isEmpty());
	}

	public function testProperty() {
		$expected = '/**
 * my prop
 *
 * my very long prop
 *
 * @var int this prop is an integer
 */';
		$property = $this->getProperty();
		$property->generateDocblock();

		$this->assertEquals($expected, $property->getDocblock()->toString());
	}

	public function testEmptyProperty() {
		$property = new PhpProperty(self::PROP);
		$property->generateDocblock();
		$this->assertTrue($property->getDocblock()->isEmpty());
	}

	public function testMethod() {
		$expected = '/**
 * my method
 *
 * my very long method
 *
 * @see MyClass#myMethod see-desc
 * @param $a method-param
 * @throws \Exception when something goes wrong
 * @return string this method returns a string
 */';
		$throws = new ThrowsTag('\Exception when something goes wrong');
		$doc = new Docblock();
		$doc->appendTag($throws);

		$method = $this->getMethod();
		$method->setDocblock($doc);
		$method->generateDocblock();
		$docblock = $method->getDocblock();

		$see = new SeeTag('MyClass#myMethod see-desc');
		$docblock->appendTag($see);

		$this->assertSame($docblock, $doc);
		$this->assertEquals($expected, $docblock->toString());
	}

	public function testEmptyMethod() {
		$method = new PhpMethod(self::METHOD);
		$method->generateDocblock();
		$this->assertTrue($method->getDocblock()->isEmpty());
	}

	public function testEmptyDocblock() {
		$docblock = new Docblock();
		$this->assertEquals("/**\n */", $docblock->toString());
	}

	public function testObjectParam() {
		$expected = '/**
 * @param Request $r
 * @param mixed $a
 * @return Response this method returns a response object
 */';
		$function = PhpFunction::create(self::METHOD)->setType('Response', 'this method returns a response object')->addParameter(PhpParameter::create('r')->setType('Request'))->addParameter(PhpParameter::create('a')->setType('mixed'));
		$function->generateDocblock();
		$this->assertSame($expected, $function->getDocblock()->toString());
	}
}
