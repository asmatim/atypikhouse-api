<?php

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 *
 * @method static OfferStatus DELETED()
 * @method static OfferStatus PUBLISHED()
 * @method static OfferStatus UNPUBLISHED()
 *
 */
final class OfferStatus extends Enum
{
    private const DELETED = 'deleted';
    private const PUBLISHED = 'published';
    private const UNPUBLISHED = 'unpublished';
}
