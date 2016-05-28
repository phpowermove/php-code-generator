<?php
namespace gossi\codegen\tests\model;

use gossi\codegen\model\PhpClass;
use gossi\codegen\model\PhpMethod;
use gossi\codegen\utils\ReflectionUtils;

class AbstractPhpStructTest extends \PHPUnit_Framework_TestCase {

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

		$this->assertEquals([], $class->getUseStatements());
		$this->assertSame($class, $class->setUseStatements([
			'foo' => 'bar'
		]));
		$this->assertEquals([
			'foo' => 'bar'
		], $class->getUseStatements());
		$this->assertSame($class, $class->addUseStatement('Foo\Bar'));
		$this->assertEquals([
			'foo' => 'bar',
			'Bar' => 'Foo\Bar'
		], $class->getUseStatements());
		$this->assertSame($class, $class->addUseStatement('Foo\Bar', 'Baz'));
		$this->assertEquals([
			'foo' => 'bar',
			'Bar' => 'Foo\Bar',
			'Baz' => 'Foo\Bar'
		], $class->getUseStatements());
		$this->assertTrue($class->hasUseStatement('bar'));
		$class->removeUseStatement('bar');
		$this->assertFalse($class->hasUseStatement('bar'));

		// declareUse
		$this->assertEquals('ArrayList', $class->declareUse('phootwork\collection\ArrayList'));
		$this->assertEquals('Foo', $class->declareUse('phootwork\collection\Stack', 'Foo'));
		$class->declareUses('phootwork\collection\Set', 'phootwork\collection\Map');
		$this->assertTrue($class->hasUseStatement('phootwork\collection\Set'));
		$this->assertTrue($class->hasUseStatement('phootwork\collection\Map'));

		// from reflection
		require_once __DIR__ . '/../fixture/DummyTrait.php';
		$statements = ReflectionUtils::getUseStatements(new \ReflectionClass('gossi\\codegen\\tests\\fixture\\DummyTrait'));
		$this->assertEquals(['gossi\\codegen\\tests\\fixture\\VeryDummyTrait'], $statements);

		require_once __DIR__ . '/../fixture/ClassWithTraits.php';
		$statements = ReflectionUtils::getUseStatements(new \ReflectionClass('gossi\\codegen\\tests\\fixture\\ClassWithTraits'));
		$this->assertEquals(['DT' => 'gossi\\codegen\\tests\\fixture\\DummyTrait'], $statements);
	}

	public function testMethods() {
		$class = new PhpClass();

		$this->assertEquals([], $class->getMethods());
		$this->assertSame($class, $class->setMethod($method = new PhpMethod('foo')));
		$this->assertSame([
			'foo' => $method
		], $class->getMethods());
		$this->assertTrue($class->hasMethod('foo'));
		$this->assertSame($method, $class->getMethod('foo'));
		$this->assertSame($class, $class->removeMethod($method));
		$this->assertEquals([], $class->getMethods());
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
		], $class->getMethods());
		$this->assertEquals(['foo', 'bar'], $class->getMethodNames());
		$this->assertNull($orphaned->getParent());
		$this->assertSame($method, $class->getMethod($method));
		$this->assertTrue($class->hasMethod($method));
		$this->assertSame($class, $class->removeMethod($method));
		$this->assertFalse($class->hasMethod($method));

		$this->assertNotEmpty($class->getMethods());
		$class->clearMethods();
		$this->assertEmpty($class->getMethods());

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

		$this->assertEquals([], $class->getRequiredFiles());
		$this->assertSame($class, $class->setRequiredFiles([
			'foo'
		]));
		$this->assertEquals([
			'foo'
		], $class->getRequiredFiles());
		$this->assertSame($class, $class->addRequiredFile('bar'));
		$this->assertEquals([
			'foo',
			'bar'
		], $class->getRequiredFiles());
	}
}
