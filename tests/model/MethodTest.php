<?php
namespace gossi\codegen\tests\model;

use gossi\codegen\model\PhpMethod;
use gossi\codegen\model\PhpParameter;

/**
 * @group model
 */
class MethodTest extends \PHPUnit_Framework_TestCase {

	public function testParameters() {
		$method = new PhpMethod('needsName');

		$this->assertEquals([], $method->getParameters());
		$this->assertSame($method, $method->setParameters($params = [
			new PhpParameter('a')
		]));
		$this->assertSame($params, $method->getParameters());

		$this->assertSame($method, $method->addParameter($param = new PhpParameter('b')));
		$this->assertSame($param, $method->getParameter('b'));
		$this->assertSame($param, $method->getParameter(1));
		$params[] = $param;
		$this->assertSame($params, $method->getParameters());

		$this->assertSame($method, $method->removeParameter(0));
		$this->assertEquals('b', $method->getParameter(0)->getName());
		
		unset($params[0]);
		$this->assertEquals([
			$param
		], $method->getParameters());

		$this->assertSame($method, $method->addParameter($param = new PhpParameter('c')));
		$params[] = $param;
		$params = array_values($params);
		$this->assertSame($params, $method->getParameters());

		$this->assertSame($method, $method->replaceParameter(0, $param = new PhpParameter('a')));
		$params[0] = $param;
		$this->assertSame($params, $method->getParameters());
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testGetNonExistentParameterByName() {
		$method = new PhpMethod('doink');
		$method->getParameter('x');
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testGetNonExistentParameterByIndex() {
		$method = new PhpMethod('doink');
		$method->getParameter(5);
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testReplaceNonExistentParameterByIndex() {
		$method = new PhpMethod('doink');
		$method->replaceParameter(5, new PhpParameter());
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testRemoveNonExistentParameterByIndex() {
		$method = new PhpMethod('doink');
		$method->removeParameter(5);
	}

	public function testBody() {
		$method = new PhpMethod('needsName');

		$this->assertSame('', $method->getBody());
		$this->assertSame($method, $method->setBody('foo'));
		$this->assertEquals('foo', $method->getBody());
	}

	public function testReferenceReturned() {
		$method = new PhpMethod('needsName');

		$this->assertFalse($method->isReferenceReturned());
		$this->assertSame($method, $method->setReferenceReturned(true));
		$this->assertTrue($method->isReferenceReturned());
		$this->assertSame($method, $method->setReferenceReturned(false));
		$this->assertFalse($method->isReferenceReturned());
	}
}
