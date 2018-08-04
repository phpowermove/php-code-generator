<?php
namespace gossi\codegen\tests\fixtures;

/**
 * Doc Comment.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
abstract class Entity {

	private $enabled = false;

	/**
	 * @var integer
	 */
	private $id;

	private static function bar() {
	}

	/**
	 * Another doc comment.
	 *
	 * @param $a
	 * @param array $b
	 * @param \stdClass $c
	 * @param string $d
	 * @param callable $e
	 */
	final public function __construct($a, array &$b, \stdClass $c, $d = 'foo', callable $e) {
	}

	abstract protected function foo();
}
