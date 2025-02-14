<?php declare(strict_types=1);
/**
 * Copyright © Andrii, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Test\Review\Api;

/**
 * Review CRUD interface.
 * @api
 * @since 100.0.2
 */
interface ReviewRepositoryInterface
{
    /**
     * Save.
     *
     * @param \Test\Review\Api\Data\ReviewInterface $review
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Test\Review\Api\Data\ReviewInterface $review): bool;

    /**
     * Retrieve.
     *
     * @param int $reviewId
     * @return \Test\Review\Api\Data\ReviewInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById(int $reviewId): \Test\Review\Api\Data\ReviewInterface;

    /**
     * Retrieve matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Test\Review\Api\Data\ReviewSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria): \Test\Review\Api\Data\ReviewSearchResultsInterface;

    /**
     * Delete.
     *
     * @param \Test\Review\Api\Data\ReviewInterface $review
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\ReviewInterface $review): bool;

    /**
     * Delete by ID.
     *
     * @param int $reviewId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById(int $reviewId): bool;
}
