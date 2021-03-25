<?php

declare(strict_types=1);

namespace Archman\DataModel\Converters;

use Archman\DataModel\Property;
use Archman\DataModel\TypeHelper;
use Attribute;
use TypeError;

#[Attribute]
class IntConverter implements ConverterInterface
{
    public function __construct(private array $expectTypes = [])
    {
    }

    public function convert(mixed $fieldValue, Property $property): int
    {
        if (is_int($fieldValue)) {
            return $fieldValue;
        }

        if ($this->expectTypes) {
            [$valueType, $isValueObject] = TypeHelper::getValueType($fieldValue);
            if (!in_array($valueType, $this->expectTypes) &&
                (!$isValueObject || !in_array('object', $this->expectTypes))
            ) {
                throw new TypeError("unexpect type of the value: {$valueType}");
            }
        }

        return intval($fieldValue);
    }
}