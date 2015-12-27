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
		
		$this->assertEquals(array(), $class->getUseStatements());
		$this->assertSame($class, $class->setUseStatements(array(
			'foo' => 'bar'
		)));
		$this->assertEquals(array(
			'foo' => 'bar'
		), $class->getUseStatements());
		$this->assertSame($class, $class->addUseStatement('Foo\Bar'));
		$this->assertEquals(array(
			'foo' => 'bar',
			'Bar' => 'Foo\Bar'
		), $class->getUseStatements());
		$this->assertSame($class, $class->addUseStatement('Foo\Bar', 'Baz'));
		$this->assertEquals(array(
			'foo' => 'bar',
			'Bar' => 'Foo\Bar',
			'Baz' => 'Foo\Bar'
		), $class->getUseStatements());
		$this->assertTrue($class->hasUseStatement('bar'));
		$class->removeUseStatement('bar');
		$this->assertFalse($class->hasUseStatement('bar'));
		
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
		
		$this->assertEquals(array(), $class->getMethods());
		$this->assertSame($class, $class->setMethod($method = new PhpMethod('foo')));
		$this->assertSame(array(
			'foo' => $method
		), $class->getMethods());
		$this->assertTrue($class->hasMethod('foo'));
		$this->assertSame($method, $class->getMethod('foo'));
		$this->assertSame($class, $class->removeMethod($method));
		$this->assertEquals(array(), $class->getMethods());
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
		$this->assertNull($orphaned->getParent());
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
		
		$this->assertEquals(array(), $class->getRequiredFiles());
		$this->assertSame($class, $class->setRequiredFiles(array(
			'foo'
		)));
		$this->assertEquals(array(
			'foo'
		), $class->getRequiredFiles());
		$this->assertSame($class, $class->addRequiredFile('bar'));
		$this->assertEquals(array(
			'foo',
			'bar'
		), $class->getRequiredFiles());
	}
}
