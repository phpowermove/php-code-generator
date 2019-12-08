<?php
namespace gossi\codegen\tests;

use gossi\codegen\model\PhpClass;
use gossi\codegen\model\PhpConstant;
use gossi\codegen\model\PhpInterface;
use gossi\codegen\model\PhpMethod;
use gossi\codegen\model\PhpParameter;
use gossi\codegen\model\PhpProperty;
use gossi\codegen\model\PhpTrait;
use gossi\docblock\Docblock;
use gossi\docblock\tags\AuthorTag;
use gossi\docblock\tags\SinceTag;

class Fixtures {

	/**
	 * Creates the Fixture Class
	 * 
	 * @return PhpClass
	 */
	public static function createEntity() {
		$classDoc = new Docblock('/**
 * Doc Comment.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */');

		$propDoc = new Docblock('/**
 * @var int
 */');
		$class = new PhpClass();
		$class->setQualifiedName('gossi\codegen\tests\fixtures\Entity')
			->setAbstract(true)
			->setDocblock($classDoc)
			->setDescription($classDoc->getShortDescription())
			->setLongDescription($classDoc->getLongDescription())
			->addProperty(PhpProperty::create('id')
				->setVisibility('private')
				->setDocblock($propDoc)
				->addType('int')
				->setDescription($propDoc->getShortDescription()))
			->addProperty(PhpProperty::create('enabled')
				->setVisibility('private')
				->setValue(false));

		$methodDoc = new Docblock('/**
 * Another doc comment.
 *
 * @param $a
 * @param array $b
 * @param \stdClass $c
 * @param string $d
 * @param callable $e
 */');
		$method = PhpMethod::create('__construct')
			->setFinal(true)
			->addParameter(PhpParameter::create('a'))
			->addParameter(PhpParameter::create()
				->setName('b')
				->addType('array')
				->setPassedByReference(true))
			->addParameter(PhpParameter::create()
				->setName('c')
				->addType('\\stdClass'))
			->addParameter(PhpParameter::create()
				->setName('d')
				->addType('string')
				->setValue('foo'))
			->addParameter(PhpParameter::create()
				->setName('e')
				->addType('callable'))
				->setDocblock($methodDoc)
				->setDescription($methodDoc->getShortDescription())
				->setLongDescription($methodDoc->getLongDescription());

		$class->addMethod($method);
		$class->addMethod(PhpMethod::create('foo')->setAbstract(true)->setVisibility('protected'));
		$class->addMethod(PhpMethod::create('bar')->setStatic(true)->setVisibility('private'));

		return $class;
	}

	/**
	 * Create ClassWithConstants
	 * 
	 * @return PhpClass
	 */
	public static function createClassWithConstants() {
		return PhpClass::create('gossi\\codegen\\tests\\fixtures\\ClassWithConstants')
			->setConstant(PhpConstant::create('BAR')->setExpression('self::FOO'))
			->setConstant(PhpConstant::create('FOO', 'bar'))
			->setConstant(PhpConstant::create('NMBR', 300));
	}

	/**
	 * Creates ClassWithTraits
	 * 
	 * @return PhpClass
	 */
	public static function createClassWithTraits() {
		return PhpClass::create('gossi\\codegen\\tests\\fixtures\\ClassWithTraits')
			->addUseStatement('gossi\\codegen\\tests\\fixtures\\DummyTrait', 'DT')
			->addTrait('DT');
	}

	/**
	 *
	 * @return PhpClass
	 */
	public static function createABClass() {
		return PhpClass::create()
			->setName('ABClass')
			->addMethod(PhpMethod::create('a'))
			->addMethod(PhpMethod::create('b'))
			->addProperty(PhpProperty::create('a'))
			->addProperty(PhpProperty::create('b'))
			->setConstant('a', 'foo')
			->setConstant('b', 'bar');
	}

	/**
	 * Creates ClassWithComments
	 * 
	 * @return PhpClass
	 */
	public static function createClassWithComments() {
		$class = PhpClass::create('gossi\\codegen\\tests\\fixtures\\ClassWithComments');
		$class->setDescription('A class with comments');
		$class->setLongDescription('Here is a super dooper long-description');
		$docblock = $class->getDocblock();
		$docblock->appendTag(AuthorTag::create('gossi'));
		$docblock->appendTag(SinceTag::create('0.2'));

		$class->setConstant(PhpConstant::create('FOO', 'bar')
			->setDescription('Best const ever')
			->setLongDescription('Aaaand we go along long')
			->addType('string')
			->addTypeDescription('baz')
		);

		$class->addProperty(PhpProperty::create('propper')
                                       ->setDescription('best prop ever')
                                       ->setLongDescription('Aaaand we go along long long')
                                       ->addType('string')
                                       ->addTypeDescription('Wer macht sauber?')
		);

		$class->addMethod(PhpMethod::create('setup')
                                   ->setDescription('Short desc')
                                   ->setLongDescription('Looong desc')
                                   ->addParameter(PhpParameter::create('moo')
				->addType('boolean')
				->addTypeDescription('makes a cow'))
                                   ->addParameter(PhpParameter::create('foo')
				->addType('foo', 'makes a fow'))
                                   ->addType('boolean', 'true on success and false if it fails')
		);

		return $class;
	}

	/**
	 * Creates DummyInterface
	 * 
	 * @return PhpInterface
	 */
	public static function createDummyInterface() {
		$interface = PhpInterface::create('DummyInterface')
			->setNamespace('gossi\codegen\tests\fixtures')
			->setDescription('Dummy docblock')
			->addMethod(PhpMethod::create('foo'));
		$interface->generateDocblock();

		return $interface;
	}

	/**
	 * Creates DummyTrait
	 * 
	 * @return PhpTrait
	 */
	public static function createDummyTrait() {
		$trait = PhpTrait::create('DummyTrait')
			->setNamespace('gossi\\codegen\\tests\\fixtures')
			->setDescription('Dummy docblock')
			->addMethod(PhpMethod::create('foo')->setVisibility('public'))
			->addProperty(PhpProperty::create('iAmHidden')->setVisibility('private'))
			->addTrait('VeryDummyTrait');
		$trait->generateDocblock();

		return $trait;
	}

}
