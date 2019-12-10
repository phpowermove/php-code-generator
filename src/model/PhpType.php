<?php

namespace gossi\codegen\model;

use gossi\codegen\model\parts\QualifiedNamePart;

class PhpType implements PhpTypeInterface
{
    use QualifiedNamePart;

    public function __construct($qualifiedName)
    {
        $this->setQualifiedName($qualifiedName);
    }
}
