<?php declare(strict_types=1);
/**
 * Copyright © Andrii, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Test\Review\Service;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Test\Review\Api\ReviewRepositoryInterface;
use Test\Review\Api\ServiceCalculateProductRating;

class CalculateProductRating implements ServiceCalculateProductRating
{
    public function __construct(
        private readonly ReviewRepositoryInterface $reviewRepository,
        private readonly SearchCriteriaBuilder $searchCriteriaBuilder,
        private readonly SortOrderBuilder $sortOrderBuilder,
    ) {
    }

    public function calculate(?int $productId): ?string
    {
        if (!$productId) {
            throw new \Exception('please provide productId');
        }

        $this->searchCriteriaBuilder->addFilter('product_id', $productId);
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $items = $this->reviewRepository->getList($searchCriteria)->getItems();

        if (is_array($items) && count($items) > 0) {
            $amount = count($items);
            $rating = 0;
            foreach ($items as $item) {
                $rating += (int)$item->getRating();
            }
            try {
                $ratingLabel = sprintf('%d/%d', round($rating / $amount), self::MAX_RATING_VALUE);
            } catch (\DivisionByZeroError $e) {
                throw new \Exception('Division by zero');
            }

            return $ratingLabel;
        }

        return self::DEFAULT_RATING_VALUE;
    }
}
