<?php

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 *
 * @method static DynamicPropertyType BINARY()
 * @method static DynamicPropertyType NUMERICAL()
 * @method static DynamicPropertyType TEXT()
 *
 */
final class DynamicPropertyType extends Enum
{
    private const BINARY = 'BINARY';
    private const NUMERICAL = 'NUMERICAL';
    private const TEXT = 'TEXT';
}
