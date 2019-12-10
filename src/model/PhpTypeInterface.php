<?php

namespace gossi\codegen\model;

interface PhpTypeInterface extends NamespaceInterface
{
    public function getName(): ?string;

    public function getQualifiedName(): ?string;

    public function setName(?string $name);

    public function setQualifiedName(?string $qualifiedName);

    public function __toString(): string;
}
