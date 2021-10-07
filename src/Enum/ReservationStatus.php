<?php

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 *
 * @method static ReservationStatus PENDING()
 * @method static ReservationStatus CONFIRMED()
 * @method static ReservationStatus CANCELED()
 * @method static ReservationStatus COMPLETED()
 *
 */
final class ReservationStatus extends Enum
{
    private const PENDING = 'pending';
    private const CONFIRMED = 'confirmed';
    private const CANCELED = 'canceled';
    private const COMPLETED = 'completed';
}
