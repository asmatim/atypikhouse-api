<?php

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 *
 * @method static OfferCommentStatus PENDING()
 * @method static OfferCommentStatus APPROUVED()
 * @method static OfferCommentStatus REJECTED()
 *
 */
final class OfferCommentStatus extends Enum
{
    private const PENDING = 'pending';
    private const APPROUVED = 'approved';
    private const REJECTED = 'rejected';
}
