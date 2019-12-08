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
}
