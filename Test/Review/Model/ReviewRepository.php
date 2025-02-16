<?php declare(strict_types=1);
/**
 * Copyright © Andrii, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Test\Review\Model;

use sprintf;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\EntityManager\HydratorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Test\Review\Api\Data;
use Test\Review\Api\Data\ReviewInterface;
use Test\Review\Api\Data\ReviewSearchResultsInterface;
use Test\Review\Api\ReviewRepositoryInterface;
use Test\Review\Model\Review;
use Test\Review\Model\ReviewFactory;
use Test\Review\Model\ResourceModel\Review as ResourceReview;
use Test\Review\Model\ResourceModel\Review\Collection as CollectionReview;
use Test\Review\Model\ResourceModel\Review\CollectionFactory as CollectionFactoryReview;
use Magento\Framework\Webapi\Rest\Request;
use Test\Review\Api\ValidateRatingInterface;
use Psr\Log\LoggerInterface;
/**
 * Default repo impl.
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ReviewRepository implements ReviewRepositoryInterface
{
    public function __construct(
        private readonly CollectionFactoryReview $reviewCollectionFactory,
        private readonly ResourceReview $resource,
        private readonly ReviewFactory $reviewFactory,
        private readonly Data\ReviewSearchResultsInterfaceFactory $searchResultsFactory,
        private readonly Request $request,
        private readonly ValidateRatingInterface $validateRating,
        private readonly LoggerInterface $logger,
        private          CollectionProcessorInterface $collectionProcessor,
        private          ?HydratorInterface $hydrator = null,
    ) {
        $this->collectionProcessor = $collectionProcessor ?: $this->getCollectionProcessor();
        $this->hydrator = $hydrator ?: ObjectManager::getInstance()
            ->get(HydratorInterface::class);
    }

    public function save(ReviewInterface $review): bool
    {
        try {
            $reviewId = (int)$this->request->getParam('id');
            if ($reviewId && !($review instanceof Review && $review->getOrigData())) {
                $review = $this->hydrator->hydrate($this->getById($reviewId), $this->hydrator->extract($review));
            }
            if (!$this->validateRating->validate($review->getRating())){
                $this->logger->info(sprintf('Rating value is wrong %d', $review->getRating()));
                throw new \Exception('Rating value is wrong');
            }
            $this->resource->save($review);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return true;
    }

    public function getById(int $reviewId): ReviewInterface
    {
        $review = $this->reviewFactory->create();
        $this->resource->load($review, $reviewId);
        if (!$review->getId()) {
            throw new NoSuchEntityException(__('The Review with the "%1" ID doesn\'t exist.', $reviewId));
        }
        return $review;
    }

    public function getList(SearchCriteriaInterface $criteria): ReviewSearchResultsInterface
    {
        /** @var CollectionReview $collection */
        $collection = $this->reviewCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var Data\ReviewSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    public function delete(Data\ReviewInterface $review): bool
    {
        try {
            $this->resource->delete($review);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    public function deleteById(int $reviewId): bool
    {
        return $this->delete($this->getById($reviewId));
    }
}
