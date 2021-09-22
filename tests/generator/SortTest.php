<?php
namespace phpowermove\codegen\tests\generator;

use phpowermove\codegen\generator\comparator\DefaultConstantComparator;
use phpowermove\codegen\generator\comparator\DefaultMethodComparator;
use phpowermove\codegen\generator\comparator\DefaultPropertyComparator;
use phpowermove\codegen\generator\comparator\DefaultUseStatementComparator;
use phpowermove\codegen\model\PhpConstant;
use phpowermove\codegen\model\PhpMethod;
use phpowermove\codegen\model\PhpProperty;
use phootwork\collection\ArrayList;
use PHPUnit\Framework\TestCase;

/**
 * @group generator
 */
class SortTest extends TestCase {

	public function testDefaultUseStatementComparator() {
		$list = new ArrayList();

		$list->add('phootwork\lang\Comparable');
		$list->add('phootwork\lang\Text');
		$list->add('Doctrine\Instantiator\Instantiator');
		$list->add('phootwork\collection\ArrayList');
		$list->add('Symfony\Component\Finder\Finder');
		$list->add('phootwork\file\Path');
		$list->add('phpowermove\docblock\Docblock');
		$list->add('phootwork\lang\Text');
		$list->add('phootwork\tokenizer\PhpTokenizer');
		$list->add('phootwork\collection\Map');

		$list->sort(new DefaultUseStatementComparator());
		$this->assertEquals([
			'phpowermove\docblock\Docblock',
			'phootwork\collection\ArrayList',
			'phootwork\collection\Map',
			'phootwork\file\Path',
			'phootwork\lang\Comparable',
			'phootwork\lang\Text',
			'phootwork\lang\Text',
			'phootwork\tokenizer\PhpTokenizer',
			'Doctrine\Instantiator\Instantiator',
			'Symfony\Component\Finder\Finder',
		], $list->toArray());
	}

	public function testDefaultConstantComparator() {
		$list = new ArrayList();

		$list->add(new PhpConstant('FOO'));
		$list->add(new PhpConstant('bar'));
		$list->add(new PhpConstant('BAR'));
		$list->add(new PhpConstant('baz'));
		$list->add(new PhpConstant('BAZ'));

		$list->sort(new DefaultConstantComparator());
		$ordered = $list->map(function ($item) {
			return $item->getName();
		})->toArray();

		$this->assertEquals([
			'bar',
			'baz',
			'BAR',
			'BAZ',
			'FOO'
		], $ordered);
	}

	public function testDefaultMethodComparator() {
		$list = new ArrayList();

		$list->add(PhpMethod::create('moop')->setStatic(true));
		$list->add(PhpMethod::create('arr')->setVisibility(PhpMethod::VISIBILITY_PRIVATE));
		$list->add(PhpMethod::create('bar')->setVisibility(PhpMethod::VISIBILITY_PROTECTED));
		$list->add(PhpMethod::create('foo'));
		$list->add(PhpMethod::create('baz'));

		$list->sort(new DefaultMethodComparator());
		$ordered = $list->map(function ($item) {
			return $item->getName();
		})->toArray();

		$this->assertEquals([
			'moop', 'baz', 'foo', 'bar', 'arr'
		], $ordered);
	}

	public function testDefaultPropertyComparator() {
		$list = new ArrayList();

		$list->add(PhpProperty::create('arr')->setVisibility(PhpProperty::VISIBILITY_PRIVATE));
		$list->add(PhpProperty::create('bar')->setVisibility(PhpProperty::VISIBILITY_PROTECTED));
		$list->add(PhpProperty::create('foo'));
		$list->add(PhpProperty::create('baz'));

		$list->sort(new DefaultPropertyComparator());
		$ordered = $list->map(function ($item) {
			return $item->getName();
		})->toArray();

		$this->assertEquals([
			'baz', 'foo', 'bar', 'arr'
		], $ordered);
	}

}
