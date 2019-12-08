<?php
declare(strict_types=1);

namespace gossi\codegen\utils;

use gossi\codegen\generator\builder\parts\TypeBuilderPart;
use gossi\codegen\model\AbstractPhpStruct;

class TypeUtils
{
    public static function expressionToTypes(?string $typeExpression): array
    {
        if (!$typeExpression) {
            return [];
        }

        return explode('|', $typeExpression);
    }

    public static function typesToExpression(array $types): string
    {
        return implode('|', $types);
    }

    public static function guessQualifiedName(AbstractPhpStruct $stuct, string $type): string
    {
        if (in_array($type, TypeBuilderPart::$noTypeHints, true)) {
            return $type;
        }

        $suffix = '';
        if (strpos($type, '[]') !== false) {
            $type = str_replace('[]', '', $type);
            $suffix = '[]';
        }

        $uses = $stuct->getUseStatements();
        foreach ($uses as $use) {
            $regexp = '/\\\\' . preg_quote($type, '/') . '$/';
            if (preg_match($regexp, $use)) {
                return $use . $suffix;
            }
        }

        $sameNamespace = $stuct->getNamespace() . '\\' . $type;
        if (class_exists($sameNamespace)) {
            return $sameNamespace . $suffix;
        }

        return $type . $suffix;
    }
}
