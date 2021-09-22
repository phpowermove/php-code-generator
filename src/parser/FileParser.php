<?php
declare(strict_types=1);

namespace phpowermove\codegen\parser;

use phpowermove\codegen\parser\visitor\ParserVisitorInterface;
use phootwork\collection\Set;
use phootwork\file\exception\FileNotFoundException;
use phootwork\file\File;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Parser;

class FileParser extends NodeVisitorAbstract {

	private $visitors;
	private $filename;

	public function __construct($filename) {
		$this->filename = $filename;
		$this->visitors = new Set();
	}

	public function addVisitor(ParserVisitorInterface $visitor) {
		$this->visitors->add($visitor);
		return $this;
	}

	public function removeVisitor(ParserVisitorInterface $visitor) {
		$this->visitors->remove($visitor);
		return $this;
	}

	public function hasVisitor(ParserVisitorInterface $visitor): bool {
		return $this->visitors->contains($visitor);
	}

	/**
	 * @throws FileNotFoundException
	 */
	public function parse() {
		$file = new File($this->filename);

		if (!$file->exists()) {
			throw new FileNotFoundException(sprintf('File (%s) does not exist.', $this->filename));
		}

		$parser = $this->getParser();
		$traverser = new NodeTraverser();
		$traverser->addVisitor($this);
		$traverser->traverse($parser->parse($file->read()));
	}

	private function getParser(): Parser {
		$factory = new \PhpParser\ParserFactory();
		return $factory->create(\PhpParser\ParserFactory::PREFER_PHP7);
	}

	public function enterNode(Node $node) {
		foreach ($this->visitors as $visitor) {
			switch ($node->getType()) {
				case 'Stmt_Namespace':
					$visitor->visitNamespace($node);
					break;

				case 'Stmt_UseUse':
					$visitor->visitUseStatement($node);
					break;

				case 'Stmt_Class':
					$visitor->visitStruct($node);
					$visitor->visitClass($node);
					break;

				case 'Stmt_Interface':
					$visitor->visitStruct($node);
					$visitor->visitInterface($node);
					break;

				case 'Stmt_Trait':
					$visitor->visitStruct($node);
					$visitor->visitTrait($node);
					break;

				case 'Stmt_TraitUse':
					$visitor->visitTraitUse($node);
					break;

				case 'Stmt_ClassConst':
					$visitor->visitConstants($node);
					break;

				case 'Stmt_Property':
					$visitor->visitProperty($node);
					break;

				case 'Stmt_ClassMethod':
					$visitor->visitMethod($node);
					break;
			}
		}
	}
}
