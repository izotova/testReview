<?php declare(strict_types=1);
/**
 * Copyright © Andrii, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Test\Review\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for Review search results.
 * @api
 * @since 100.0.2
 */
interface ReviewSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get list.
     *
     * @return \Test\Review\Api\Data\ReviewInterface[]
     */
    public function getItems();

    /**
     * Set list.
     *
     * @param \Test\Review\Api\Data\ReviewInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
