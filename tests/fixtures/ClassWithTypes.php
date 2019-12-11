<?php
declare(strict_types=1);

namespace gossi\codegen\tests\fixtures;

class ClassWithTypes
{
    /**
     * @param ClassWithConstants[]|ClassWithTraits|null|string|\StdClass $toto
     */
    public function test(ClassWithComments $toto)
    {

    }

    public function test2(?string $toto2) {

    }

    public function test3(int $toto3 = null)
    {

    }
}
