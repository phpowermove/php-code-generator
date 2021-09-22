<?php
namespace phpowermove\codegen\tests\model;

use phpowermove\codegen\model\PhpClass;
use phpowermove\codegen\model\PhpInterface;
use phpowermove\codegen\model\PhpMethod;
use phpowermove\codegen\model\PhpTrait;
use PHPUnit\Framework\TestCase;

/**
 * @group model
 */
class AbstractPhpStructTest extends TestCase {

	public function testCreate() {
		$class = PhpClass::create();
		$this->assertTrue($class instanceof PhpClass);

		$interface = PhpInterface::create();
		$this->assertTrue($interface instanceof PhpInterface);

		$trait = PhpTrait::create();
		$this->assertTrue($trait instanceof PhpTrait);
	}

	public function testQualifiedName() {
		$class = new PhpClass();
		$this->assertNull($class->getName());

		$class = new PhpClass('foo');
		$this->assertEquals('foo', $class->getName());
		$this->assertEquals('foo', $class->getQualifiedName());
		$this->assertSame($class, $class->setName('bar'));
		$this->assertEquals('bar', $class->getName());

		$class->setQualifiedName('\full\qualified\Name');
		$this->assertEquals('full\qualified', $class->getNamespace());
		$this->assertEquals('Name', $class->getName());
		$this->assertEquals('full\qualified\Name', $class->getQualifiedName());

		$class->setNamespace('a\b');
		$this->assertEquals('a\b', $class->getNamespace());
		$this->assertEquals('a\b\Name', $class->getQualifiedName());
	}

	public function testUseStatements() {
		$class = new PhpClass();

		$this->assertTrue($class->getUseStatements()->isEmpty());
		$this->assertSame($class, $class->setUseStatements([
			'foo' => 'bar'
		]));
		$this->assertEquals([
			'foo' => 'bar'
		], $class->getUseStatements()->toArray());
		$this->assertSame($class, $class->addUseStatement('Foo\Bar'));
		$this->assertEquals([
			'foo' => 'bar',
			'Bar' => 'Foo\Bar'
		], $class->getUseStatements()->toArray());
		$this->assertSame($class, $class->addUseStatement('Foo\Bar', 'Baz'));
		$this->assertEquals([
			'foo' => 'bar',
			'Bar' => 'Foo\Bar',
			'Baz' => 'Foo\Bar'
		], $class->getUseStatements()->toArray());
		$this->assertTrue($class->hasUseStatement('bar'));
		$class->removeUseStatement('bar');
		$this->assertFalse($class->hasUseStatement('bar'));

		$class->clearUseStatements();
		$class->addUseStatement('ArrayList');
		$this->assertEquals([
			'ArrayList' => 'ArrayList'
		], $class->getUseStatements()->toArray());

		// declareUse
		$this->assertEquals('ArrayList', $class->declareUse('phootwork\collection\ArrayList'));
		$this->assertEquals('Foo', $class->declareUse('phootwork\collection\Stack', 'Foo'));
		$class->declareUses('phootwork\collection\Set', 'phootwork\collection\Map');
		$this->assertTrue($class->hasUseStatement('phootwork\collection\Set'));
		$this->assertTrue($class->hasUseStatement('phootwork\collection\Map'));
	}

	public function testMethods() {
		$class = new PhpClass();

		$this->assertTrue($class->getMethods()->isEmpty());
		$this->assertSame($class, $class->setMethod($method = new PhpMethod('foo')));
		$this->assertSame([
			'foo' => $method
		], $class->getMethods()->toArray());
		$this->assertTrue($class->hasMethod('foo'));
		$this->assertSame($method, $class->getMethod('foo'));
		$this->assertSame($class, $class->removeMethod($method));
		$this->assertEquals([], $class->getMethods()->toArray());
		$class->setMethod($orphaned = new PhpMethod('orphaned'));
		$this->assertSame($class, $orphaned->getParent());
		$this->assertTrue($class->hasMethod($orphaned));
		$this->assertSame($class, $class->setMethods([
			$method,
			$method2 = new PhpMethod('bar')
		]));
		$this->assertSame([
			'foo' => $method,
			'bar' => $method2
		], $class->getMethods()->toArray());
		$this->assertEquals(['foo', 'bar'], $class->getMethodNames()->toArray());
		$this->assertNull($orphaned->getParent());
		$this->assertSame($method, $class->getMethod($method));
		$this->assertTrue($class->hasMethod($method));
		$this->assertSame($class, $class->removeMethod($method));
		$this->assertFalse($class->hasMethod($method));

		$this->assertFalse($class->getMethods()->isEmpty());
		$class->clearMethods();
		$this->assertTrue($class->getMethods()->isEmpty());

		try {
			$this->assertEmpty($class->getMethod('method-not-found'));
		} catch (\InvalidArgumentException $e) {
			$this->assertNotNull($e);
		}
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testRemoveMethodThrowsExceptionWhenConstantDoesNotExist() {
		$class = new PhpClass();
		$class->removeMethod('foo');
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testGetMethodThrowsExceptionWhenConstantDoesNotExist() {
		$class = new PhpClass();
		$class->getMethod('foo');
	}

	public function testDocblock() {
		$class = new PhpClass();

		$this->assertNotNull($class->getDocblock());
		$this->assertSame($class, $class->setDocblock('foo'));
		$this->assertEquals('foo', $class->getDocblock()->getShortDescription());
	}

	public function testRequiredFiles() {
		$class = new PhpClass();

		$this->assertEquals([], $class->getRequiredFiles()->toArray());
		$this->assertSame($class, $class->setRequiredFiles([
			'foo'
		]));
		$this->assertEquals([
			'foo'
		], $class->getRequiredFiles()->toArray());
		$this->assertSame($class, $class->addRequiredFile('bar'));
		$this->assertEquals([
			'foo',
			'bar'
		], $class->getRequiredFiles()->toArray());
	}
}
