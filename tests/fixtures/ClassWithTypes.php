<?php
declare(strict_types=1);

namespace gossi\codegen\tests\fixtures;

class ClassWithTypes
{
    /**
     * @param ClassWithConstants[]|ClassWithTraits|null|string|ClassWithComments|\StdClass $toto
     */
    public function test(ClassWithComments $toto)
    {

    }
}
