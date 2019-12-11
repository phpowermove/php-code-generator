<?php
namespace gossi\codegen\tests\fixtures;

use gossi\codegen\tests\fixtures\sub\SubClass;

class ClassWithTypes {

    /**
     * @param ClassWithConstants[]|SubClass|null|string|\StdClass $toto
     */
    public function test(?iterable $toto) {
    }

    public function test2(?string $toto2) {
    }

    public function test3(?int $toto3 = null) {
    }
}
