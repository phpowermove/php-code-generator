<?php
namespace gossi\codegen\tests\fixture;

/**
 * A class with comments
 * 
 * Here is a super dooper long-description
 * 
 * @author gossi
 * @since 0.2
 */
class ClassWithComments {

	/**
	 * Best const ever
	 * 
	 * Aaaand we go along long
	 * 
	 * @var string baz
	 */
	const FOO = 'bar';

	/**
	 * Best prop ever
	 * 
	 * Aaaand we go along long long
	 * 
	 * @var string Wer macht sauber?
	 */
	private $propper = 'Meister';

	/**
	 * Short desc
	 * 
	 * Looong desc
	 * 
	 * @param boolean $moo makes a cow
	 * @param string $foo makes a fow
	 * @return boolean true on success and false if it fails
	 */
	public function setup($moo, $foo = 'test123') {
	}
}
