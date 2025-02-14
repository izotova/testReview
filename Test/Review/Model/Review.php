<?php declare(strict_types=1);
/**
 * Copyright © Andrii, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Test\Review\Model;

use Magento\Framework\Model\AbstractModel;
use Test\Review\Model\ResourceModel\Review as ResourceModelReview;
use Test\Review\Api\Data\ReviewInterface;

/**
 * Review model
 *
 * @api
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @since 100.0.2
 */
class Review extends AbstractModel implements ReviewInterface
{
    protected function _construct(): void
    {
        $this->_init(ResourceModelReview::class);
    }

    public function getRating(): ?int
    {
        return (int)$this->getData(self::RATING);
    }

    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    public function getUpdatedAt(): ?string
    {
        return $this->getData(self::UPDATED_AT);
    }

    public function getCustomerId(): int
    {
        return (int)$this->getData(self::CUSTOMER_ID);
    }

    public function getProductId(): int
    {
        return (int)$this->getData(self::PRODUCT_ID);
    }

    public function setRating(int $rating): ReviewInterface
    {
        return $this->setData(self::RATING, $rating);
    }

    public function setCustomerId(int $customerId): ReviewInterface
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    public function setProductId(int $productId): ReviewInterface
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    public function setCreatedAt(?string $createdAt): ReviewInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    public function setUpdatedAt(?string $updatedAt): ReviewInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
