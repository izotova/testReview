<?php declare(strict_types=1);
/**
 * Copyright © Andrii, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Test\Review\Api\Data;

/**
 * Test Review interface.
 * @api
 * @since 100.0.2
 */
interface ReviewInterface
{
    /**#@+
     * Constants for keys
     */
    const ID          = 'id';
    const CUSTOMER_ID = 'customer_id';
    const PRODUCT_ID  = 'product_id';
    const RATING      = 'rating';
    const CREATED_AT  = 'created_at';
    const UPDATED_AT  = 'updated_at';
    /**#@-*/

    /**
     * Get Rating
     *
     * @return int|null
     */
    public function getRating(): ?int;

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * Get CustomerId
     *
     * @return int
     */
    public function getCustomerId(): int;

    /**
     * Get ProductIds
     *
     * @return int
     */
    public function getProductId(): int;

    /**
     * Set rating
     *
     * @param int $rating
     * @return ReviewInterface
     */
    public function setRating(int $rating): self;

    /**
     * Set CustomerId
     *
     * @param int $customerId
     * @return ReviewInterface
     */
    public function setCustomerId(int $customerId): self;

    /**
     * Set ProductId
     *
     * @param int $productId
     * @return ReviewInterface
     */
    public function setProductId(int $productId): self;

    /**
     * Set CreatedAt
     *
     * @param string|null $createdAt
     * @return ReviewInterface
     */
    public function setCreatedAt(?string $createdAt): self;

    /**
     * Set UpdatedAt
     *
     * @param string|null $updatedAt
     * @return ReviewInterface
     */
    public function setUpdatedAt(?string $updatedAt): self;
}
