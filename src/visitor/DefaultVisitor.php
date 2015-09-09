<?php
/*
 * Copyright 2011 Johannes M. Schmitt <schmittjoh@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace gossi\codegen\visitor;

use gossi\codegen\model\NamespaceInterface;
use gossi\codegen\model\AbstractPhpStruct;
use gossi\codegen\model\DocblockInterface;
use gossi\codegen\model\TraitsInterface;
use gossi\codegen\model\PhpClass;
use gossi\codegen\model\PhpInterface;
use gossi\codegen\model\PhpTrait;
use gossi\codegen\model\PhpConstant;
use gossi\codegen\model\PhpProperty;
use gossi\codegen\model\PhpMethod;
use gossi\codegen\model\PhpFunction;
use gossi\codegen\utils\Writer;
use gossi\docblock\Docblock;

/**
 * The default code generation visitor.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class DefaultVisitor implements GeneratorVisitorInterface {

	protected $writer;

	protected $scalarTypeHints;
	protected $returnTypeHints;

	protected static $noTypeHints = [
		'string',
		'int',
		'integer',
		'bool',
		'boolean',
		'float',
		'double',
		'object',
		'mixed',
		'resource'
	];

	public function __construct($scalarTypeHints = false, $returnTypeHints = false) {
		$this->scalarTypeHints = $scalarTypeHints;
		$this->returnTypeHints = $returnTypeHints;
		$this->writer = new Writer();
	}

	public function reset() {
		$this->writer->reset();
	}

	private function ensureBlankLine() {
		if (!$this->writer->endsWith("\n\n") && strlen($this->writer->rtrim()->getContent()) > 0) {
			$this->writer->writeln();
		}
	}

	protected function visitNamespace(NamespaceInterface $model) {
		if ($namespace = $model->getNamespace()) {
			$this->writer->writeln('namespace ' . $namespace . ';');
		}
	}

	protected function visitRequiredFiles(AbstractPhpStruct $struct) {
		if ($files = $struct->getRequiredFiles()) {
			$this->ensureBlankLine();
			foreach ($files as $file) {
				$this->writer->writeln('require_once ' . var_export($file, true) . ';');
			}
		}
	}

	protected function visitUseStatements(AbstractPhpStruct $struct) {
		if ($useStatements = $struct->getUseStatements()) {
			$this->ensureBlankLine();
			foreach ($useStatements as $alias => $namespace) {
				if (false === strpos($namespace, '\\')) {
					$commonName = $namespace;
				} else {
					$commonName = substr($namespace, strrpos($namespace, '\\') + 1);
				}

				if (false === strpos($namespace, '\\') && !$struct->getNamespace()) {
					//avoid fatal 'The use statement with non-compound name '$commonName' has no effect'
					continue;
				}

				$this->writer->write('use ' . $namespace);

				if ($commonName !== $alias) {
					$this->writer->write(' as ' . $alias);
				}

				$this->writer->write(";\n");
			}
			$this->ensureBlankLine();
		}
	}

	protected function visitDocblock(Docblock $docblock) {
		if (!$docblock->isEmpty()) {
			$this->writeDocblock($docblock);
		}
	}

	protected function writeDocblock(Docblock $docblock) {
		$docblock = $docblock->toString();
		if (!empty($docblock)) {
			$this->ensureBlankLine();
			$this->writer->writeln($docblock);
		}
	}

	protected function visitTraits(TraitsInterface $struct) {
		foreach ($struct->getTraits() as $trait) {
			$this->writer->write('use ');
			$this->writer->writeln($trait . ';');
		}
	}

	public function startVisitingClass(PhpClass $class) {
		$this->visitNamespace($class);
		$this->visitRequiredFiles($class);
		$this->visitUseStatements($class);
		$this->visitDocblock($class->getDocblock());

		// signature
		if ($class->isAbstract()) {
			$this->writer->write('abstract ');
		}

		if ($class->isFinal()) {
			$this->writer->write('final ');
		}

		$this->writer->write('class ');
		$this->writer->write($class->getName());

		if ($parentClassName = $class->getParentClassName()) {
			$this->writer->write(' extends ' . $parentClassName);
		}

		if ($class->hasInterfaces()) {
			$this->writer->write(' implements ');
			$this->writer->write(implode(', ', $class->getInterfaces()));
		}

		// body
		$this->writer->writeln(" {\n")->indent();

		$this->visitTraits($class);
	}

	public function startVisitingInterface(PhpInterface $interface) {
		$this->visitNamespace($interface);
		$this->visitRequiredFiles($interface);
		$this->visitUseStatements($interface);
		$this->visitDocblock($interface->getDocblock());

		// signature
		$this->writer->write('interface ');
		$this->writer->write($interface->getName());

		if ($interface->hasInterfaces()) {
			$this->writer->write(' extends ');
			$this->writer->write(implode(', ', $interface->getInterfaces()));
		}

		// body
		$this->writer->writeln(" {\n")->indent();
	}

	public function startVisitingTrait(PhpTrait $trait) {
		$this->visitNamespace($trait);
		$this->visitRequiredFiles($trait);
		$this->visitUseStatements($trait);
		$this->visitDocblock($trait->getDocblock());

		// signature
		$this->writer->write('trait ');
		$this->writer->write($trait->getName());

		// body
		$this->writer->writeln(" {\n")->indent();

		$this->visitTraits($trait);
	}

	public function startVisitingStructConstants() {
	}

	public function visitStructConstant(PhpConstant $constant) {
		$this->writer->writeln('const ' . $constant->getName() . ' = ' . $this->getPhpExport($constant->getValue()) . ';');
	}

	public function endVisitingStructConstants() {
		$this->writer->write("\n");
	}

	public function startVisitingProperties() {
	}

	public function visitProperty(PhpProperty $property) {
		$this->visitDocblock($property->getDocblock());

		$this->writer->write($property->getVisibility() . ' ' . ($property->isStatic() ? 'static ' : '') . '$' . $property->getName());

		if ($property->hasDefaultValue()) {
			$this->writer->write(' = ' . $this->getPhpExport($property->getDefaultValue()));
		}

		$this->writer->writeln(';');
	}

	protected function getPhpExport($value) {
		// Simply to be sure a null value is displayed in lowercase.
		if (null === $value) {
			return 'null';
		}

		return var_export($value, true);
	}

	public function endVisitingProperties() {
		$this->writer->writeln();
	}

	public function startVisitingMethods() {
	}

	public function visitMethod(PhpMethod $method) {
		$this->visitDocblock($method->getDocblock());

		if ($method->isAbstract()) {
			$this->writer->write('abstract ');
		}

		$this->writer->write($method->getVisibility() . ' ');

		if ($method->isStatic()) {
			$this->writer->write('static ');
		}

		$this->writer->write('function ');

		if ($method->isReferenceReturned()) {
			$this->writer->write('& ');
		}

		$this->writer->write($method->getName() . '(');

		$this->writeParameters($method->getParameters());
		$this->writer->write(")");
		$this->writeFunctionReturnType($method->getType());

		if ($method->isAbstract() || $method->getParent() instanceof PhpInterface) {
			$this->writer->write(";\n\n");

			return;
		}

		$this->writer->writeln(' {')->indent()->writeln(trim($method->getBody()))->outdent()->rtrim()->write("}\n\n");
	}

	public function endVisitingMethods() {
	}

	protected function endVisitingStruct(AbstractPhpStruct $struct) {
		$this->writer->outdent()->rtrim()->write('}');
	}

	public function endVisitingClass(PhpClass $class) {
		$this->endVisitingStruct($class);
	}

	public function endVisitingInterface(PhpInterface $interface) {
		$this->endVisitingStruct($interface);
	}

	public function endVisitingTrait(PhpTrait $trait) {
		$this->endVisitingStruct($trait);
	}

	public function visitFunction(PhpFunction $function) {
		if ($namespace = $function->getNamespace()) {
			$this->writer->write("namespace $namespace;\n\n");
		}

		$this->visitDocblock($function->getDocblock());

		$this->writer->write("function {$function->getName()}(");
		$this->writeParameters($function->getParameters());
		$this->writer->write(')');
		$this->writeFunctionReturnType($function->getType());
		$this->writer->write(" {\n")->indent()->writeln(trim($function->getBody()))->outdent()->rtrim()->write('}');
	}

	public function getContent() {
		return $this->writer->getContent();
	}

	protected function writeParameters(array $parameters) {
		$first = true;
		foreach ($parameters as $parameter) {
			if (!$first) {
				$this->writer->write(', ');
			}
			$first = false;

			if (false === strpos($parameter->getType(), '|') && ($type = $parameter->getType()) && (!in_array($type, self::$noTypeHints) || $this->scalarTypeHints)) {
				$this->writer->write($type . ' ');
			}

			if ($parameter->isPassedByReference()) {
				$this->writer->write('&');
			}

			$this->writer->write('$' . $parameter->getName());

			if ($parameter->hasDefaultValue()) {
				$this->writer->write(' = ');
				$defaultValue = $parameter->getDefaultValue();

				switch (true) {
					case is_array($defaultValue) && empty($defaultValue):
						$this->writer->write('array()');
						break;
					case ($defaultValue instanceof PhpConstant):
						$this->writer->write($defaultValue->getName());
						break;
					default:
					$this->writer->write($this->getPhpExport($defaultValue));

				}
			}
		}
	}

	protected function writeFunctionReturnType($type) {
		if ($this->returnTypeHints && false === strpos($type, '|')) {
			$this->writer->write(': ')->write($type);
		}
	}
}
