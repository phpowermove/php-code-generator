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
namespace gossi\codegen\generator;

use gossi\codegen\model\GenerateableInterface;
use gossi\codegen\visitor\GeneratorNavigator;
use gossi\codegen\visitor\GeneratorVisitor;
use gossi\codegen\visitor\GeneratorVisitorInterface;

/**
 * The default generator strategy.
 *
 * This strategy allows to change the order in which methods, properties and
 * constants are sorted.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class GeneratorStrategy {

	private $navigator;

	private $visitor;

	public function __construct(GeneratorVisitorInterface $visitor = null) {
		$this->navigator = new GeneratorNavigator();
		$this->visitor = $visitor ?: new GeneratorVisitor();
	}

	public function setConstantSortFunc(\Closure $func = null) {
		$this->navigator->setConstantSortFunc($func);
	}

	public function setMethodSortFunc(\Closure $func = null) {
		$this->navigator->setMethodSortFunc($func);
	}

	public function setPropertySortFunc(\Closure $func = null) {
		$this->navigator->setPropertySortFunc($func);
	}

	public function setUseStatementSortFunc(\Closure $func = null) {
		$this->navigator->setUseStatementSortFunc($func);
	}

	public function generate(GenerateableInterface $class) {
		$this->visitor->reset();
		$this->navigator->accept($this->visitor, $class);

		return $this->visitor->getContent();
	}
}
