<?php
declare(strict_types=1);

namespace gossi\codegen\generator\builder\parts;

use gossi\codegen\generator\ComparatorFactory;
use gossi\codegen\model\AbstractModel;
use gossi\codegen\model\AbstractPhpStruct;
use gossi\codegen\model\ConstantsInterface;
use gossi\codegen\model\DocblockInterface;
use gossi\codegen\model\NamespaceInterface;
use gossi\codegen\model\PropertiesInterface;
use gossi\codegen\model\TraitsInterface;

trait StructBuilderPart {

	/**
	 * @return void
	 */
	abstract protected function ensureBlankLine(): void;

	/**
	 * @param AbstractModel $model
	 * @return void
	 */
	abstract protected function generate(AbstractModel $model): void;

	/**
	 * @param DocblockInterface $model
	 * @return void
	 */
	abstract protected function buildDocblock(DocblockInterface $model): void;

	protected function buildHeader(AbstractPhpStruct $model): void {
		$this->buildNamespace($model);
		$this->buildRequiredFiles($model);
		$this->buildUseStatements($model);
		$this->buildDocblock($model);
	}

	protected function buildNamespace(NamespaceInterface $model): void {
		if ($namespace = $model->getNamespace()) {
			$this->writer->writeln('namespace ' . $namespace . ';');
		}
	}

	protected function buildRequiredFiles(AbstractPhpStruct $model): void {
		if ($files = $model->getRequiredFiles()) {
			$this->ensureBlankLine();
			foreach ($files as $file) {
				$this->writer->writeln('require_once ' . var_export($file, true) . ';');
			}
		}
	}

	protected function buildUseStatements(AbstractPhpStruct $model): void {
		if ($useStatements = $model->getUseStatements()) {
			$this->ensureBlankLine();
			foreach ($useStatements as $alias => $namespace) {
				if (false === strpos($namespace, '\\')) {
					$commonName = $namespace;
				} else {
					$commonName = substr($namespace, strrpos($namespace, '\\') + 1);
				}

				if (false === strpos($namespace, '\\') && !$model->getNamespace()) {
					//avoid fatal 'The use statement with non-compound name '$commonName' has no effect'
					continue;
				}

				$this->writer->write('use ' . $namespace);

				if ($commonName !== $alias) {
					$this->writer->write(' as ' . $alias);
				}

				$this->writer->writeln(';');
			}
			$this->ensureBlankLine();
		}
	}

	protected function buildTraits(TraitsInterface $model): void {
		foreach ($model->getTraits() as $trait) {
			$this->writer->write('use ');
			$this->writer->writeln($trait . ';');
		}
	}

	protected function buildConstants(ConstantsInterface $model): void {
		foreach ($model->getConstants() as $constant) {
			$this->generate($constant);
		}
	}

	protected function buildProperties(PropertiesInterface $model): void {
		foreach ($model->getProperties() as $property) {
			$this->generate($property);
		}
	}

	protected function buildMethods(AbstractPhpStruct $model): void {
		foreach ($model->getMethods() as $method) {
			$this->generate($method);
		}
	}

	private function sortUseStatements(AbstractPhpStruct $model): void {
		if ($this->config->isSortingEnabled()
				&& ($useStatementSorting = $this->config->getUseStatementSorting()) !== false) {
			if (is_string($useStatementSorting)) {
				$useStatementSorting = ComparatorFactory::createUseStatementComparator($useStatementSorting);
			}
			$model->getUseStatements()->sort($useStatementSorting);
		}
	}

	private function sortConstants(ConstantsInterface $model): void {
		if ($this->config->isSortingEnabled()
				&& ($constantSorting = $this->config->getConstantSorting()) !== false) {
			if (is_string($constantSorting)) {
				$constantSorting = ComparatorFactory::createConstantComparator($constantSorting);
			}
			$model->getConstants()->sort($constantSorting);
		}
	}

	private function sortProperties(PropertiesInterface $model): void {
		if ($this->config->isSortingEnabled()
				&& ($propertySorting = $this->config->getPropertySorting()) !== false) {
			if (is_string($propertySorting)) {
				$propertySorting = ComparatorFactory::createPropertyComparator($propertySorting);
			}
			$model->getProperties()->sort($propertySorting);
		}
	}

	private function sortMethods(AbstractPhpStruct $model): void {
		if ($this->config->isSortingEnabled()
				&& ($methodSorting = $this->config->getMethodSorting()) !== false) {
			if (is_string($methodSorting)) {
				$methodSorting = ComparatorFactory::createMethodComparator($methodSorting);
			}
			$model->getMethods()->sort($methodSorting);
		}
	}
}
