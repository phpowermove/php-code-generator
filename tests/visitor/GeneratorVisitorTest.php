<?php
namespace gossi\codegen\tests\visitor;

use gossi\codegen\model\PhpFunction;
use gossi\codegen\model\PhpMethod;
use gossi\codegen\model\PhpParameter;
use gossi\codegen\model\PhpProperty;
use gossi\codegen\utils\Writer;
use gossi\codegen\visitor\GeneratorVisitor;

class GeneratorVisitorTest extends \PHPUnit_Framework_TestCase {

	public function testVisitFunction() {
		$writer = new Writer();

		$function = new PhpFunction('foo');
		$function->addParameter(PhpParameter::create('a'))
			->addParameter(PhpParameter::create('b'))
			->setBody($writer->writeln('if ($a === $b) {')
				->indent()->writeln('throw new \InvalidArgumentException(\'$a is not allowed to be the same as $b.\');')
				->outdent()->write("}\n\n")->write('return $b;')->getContent());

		$visitor = new GeneratorVisitor();
		$visitor->visitFunction($function);

		$this->assertEquals($this->getContent('a_b_function.php'), $visitor->getContent());
	}

	public function testVisitMethod() {
		$method = new PhpMethod('foo');
		$visitor = new GeneratorVisitor();

		$method->setReferenceReturned(true);
		$visitor->visitMethod($method);

		$this->assertEquals($this->getContent('reference_returned_method.php'), $visitor->getContent());
	}

	public function testVisitMethodWithCallable() {
		if (PHP_VERSION_ID < 50400) {
			$this->markTestSkipped('`callable` is only supported in PHP >=5.4.0');
		}

		$method = new PhpMethod('foo');
		$parameter = new PhpParameter('bar');
		$parameter->setType('callable');

		$method->addParameter($parameter);

		$visitor = new GeneratorVisitor();
		$visitor->visitMethod($method);

		$this->assertEquals($this->getContent('callable_parameter.php'), $visitor->getContent());
	}

	public function testDefaultNotEmptyArray() {
		$property = new PhpProperty('fooArray');
		$visitor = new GeneratorVisitor();

		$property->setDefaultValue(['some value']);
		$visitor->visitProperty($property);

		$this->assertContains('some value', $visitor->getContent());
	}

	/**
	 *
	 * @param string $filename        	
	 */
	private function getContent($filename) {
		if (!is_file($path = __DIR__ . '/generated/' . $filename)) {
			throw new \InvalidArgumentException(sprintf('The file "%s" does not exist.', $path));
		}

		return file_get_contents($path);
	}
}
