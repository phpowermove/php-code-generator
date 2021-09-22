<?php
declare(strict_types=1);

namespace phpowermove\codegen\generator;

use phpowermove\codegen\generator\builder\AbstractBuilder;
use phpowermove\codegen\generator\builder\ClassBuilder;
use phpowermove\codegen\generator\builder\ConstantBuilder;
use phpowermove\codegen\generator\builder\FunctionBuilder;
use phpowermove\codegen\generator\builder\InterfaceBuilder;
use phpowermove\codegen\generator\builder\MethodBuilder;
use phpowermove\codegen\generator\builder\ParameterBuilder;
use phpowermove\codegen\generator\builder\PropertyBuilder;
use phpowermove\codegen\generator\builder\TraitBuilder;
use phpowermove\codegen\model\AbstractModel;
use phpowermove\codegen\model\PhpClass;
use phpowermove\codegen\model\PhpConstant;
use phpowermove\codegen\model\PhpFunction;
use phpowermove\codegen\model\PhpInterface;
use phpowermove\codegen\model\PhpMethod;
use phpowermove\codegen\model\PhpParameter;
use phpowermove\codegen\model\PhpProperty;
use phpowermove\codegen\model\PhpTrait;

class BuilderFactory {

	/** @var ModelGenerator */
	private $generator;

	private $classBuilder;
	private $constantBuilder;
	private $functionBuilder;
	private $interfaceBuilder;
	private $methodBuilder;
	private $parameterBuilder;
	private $propertyBuilder;
	private $traitBuilder;

	public function __construct(ModelGenerator $generator) {
		$this->generator = $generator;
		$this->classBuilder = new ClassBuilder($generator);
		$this->constantBuilder = new ConstantBuilder($generator);
		$this->functionBuilder = new FunctionBuilder($generator);
		$this->interfaceBuilder = new InterfaceBuilder($generator);
		$this->methodBuilder = new MethodBuilder($generator);
		$this->parameterBuilder = new ParameterBuilder($generator);
		$this->propertyBuilder = new PropertyBuilder($generator);
		$this->traitBuilder = new TraitBuilder($generator);
	}

	/**
	 * Returns the related builder for the given model
	 *
	 * @param AbstractModel $model
	 * @return AbstractBuilder
	 */
	public function getBuilder(AbstractModel $model): ?AbstractBuilder {
		if ($model instanceof PhpClass) {
			return $this->classBuilder;
		}

		if ($model instanceof PhpConstant) {
			return $this->constantBuilder;
		}

		if ($model instanceof PhpFunction) {
			return $this->functionBuilder;
		}

		if ($model instanceof PhpInterface) {
			return $this->interfaceBuilder;
		}

		if ($model instanceof PhpMethod) {
			return $this->methodBuilder;
		}

		if ($model instanceof PhpParameter) {
			return $this->parameterBuilder;
		}

		if ($model instanceof PhpProperty) {
			return $this->propertyBuilder;
		}

		if ($model instanceof PhpTrait) {
			return $this->traitBuilder;
		}

		return null;
	}

}
