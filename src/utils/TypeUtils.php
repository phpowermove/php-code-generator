<?php
declare(strict_types=1);

namespace gossi\codegen\utils;

use gossi\codegen\model\AbstractPhpStruct;

class TypeUtils
{
    public static $phpTypes = [
        'string',
        'int',
        'integer',
        'bool',
        'boolean',
        'float',
        'double',
        'object',
        'mixed',
        'resource',
        'iterable',
        'array',
        'callable',
    ];

    public static function expressionToTypes(?string $typeExpression): array {
        if (!$typeExpression) {
            return [];
        }

        return explode('|', $typeExpression);
    }

    public static function guessQualifiedName(AbstractPhpStruct $stuct, string $type): string {
        if (in_array($type, self::$phpTypes, true)) {
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

    public static function isGlobalQualifiedName(string $name): bool {
        return $name[0] === '\\' && substr_count($name, '\\') === 1;
    }

    public static function isNativeType(string $type): bool {
        return in_array($type, self::$phpTypes, true);
    }

    public static function typesToExpression(iterable $types): ?string {
        $typeExpr = '';
        foreach ($types as $type) {
            $typeExpr .= '|' . $type;
        }

        if (!$typeExpr) {
            return null;
        }

        return trim($typeExpr, '|');
    }
}
