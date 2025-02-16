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

interface ValidateRatingInterface
{
    /**
     * Save.
     *
     * @param int $rating
     * @return bool
     */
    public function validate(?int $rating): bool;
}
