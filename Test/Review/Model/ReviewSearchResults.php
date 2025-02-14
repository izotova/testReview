<?php declare(strict_types=1);
/**
 * Copyright © Andrii, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Test\Review\Model;

use Test\Review\Api\Data\ReviewSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Service Data Object with Review search results.
 */
class ReviewSearchResults extends SearchResults implements ReviewSearchResultsInterface
{
}
