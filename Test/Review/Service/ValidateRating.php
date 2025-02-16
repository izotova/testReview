<?php declare(strict_types=1);
/**
 * Copyright © Andrii, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Test\Review\Service;

use Test\Review\Api\ServiceCalculateProductRating;
use Test\Review\Api\ValidateRatingInterface;

class ValidateRating implements ValidateRatingInterface
{
    public function validate(?int $rating): bool
    {
        if ((int)$rating > ServiceCalculateProductRating::MAX_RATING_VALUE || (int)$rating < 1) {
            return false;

        }

        return true;
    }
}
