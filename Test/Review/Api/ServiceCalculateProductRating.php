<?php declare(strict_types=1);
/**
 * Copyright © Andrii, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Test\Review\Api;

/**
 * ServiceCalculateProductRating interface.
 * @api
 * @since 100.0.2
 */

interface ServiceCalculateProductRating
{
    public const MAX_RATING_VALUE = 5;
    public const DEFAULT_RATING_VALUE = '0/5';
    /**
     * Save.
     *
     * @param int $productId
     * @return string
     * @throws \Exception|\DivisionByZeroError
     */
    public function calculate(?int $productId): ?string;
}
