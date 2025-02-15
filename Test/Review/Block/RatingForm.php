<?php declare(strict_types=1);
/**
 * Copyright © Andrii, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Test\Review\Block;

use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Customer\Model\Session;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\Registry;
use Test\Review\Api\ReviewRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Test\Review\Api\ServiceCalculateProductRating;
use Psr\Log\LoggerInterface;
use Magento\Catalog\Model\Product;

class RatingForm extends Template
{

    public function __construct(
        private readonly Template\Context $context,
        private readonly Session $customerSession,
        private readonly SerializerInterface $serializer,
        private readonly ReviewRepositoryInterface $reviewRepository,
        private readonly SearchCriteriaBuilder $searchCriteriaBuilder,
        private readonly SortOrderBuilder $sortOrderBuilder,
        private readonly Registry $registry,
        private readonly ServiceCalculateProductRating $serviceCalculateProductRating,
        private readonly LoggerInterface $logger,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function getComponentJsonConfig(): string
    {
        return $this->serializer->serialize(
            $this->getCusomerDataRequest()
        );
    }

    private function getCusomerDataRequest(): ?array
    {
        $rating = $this->getCustomerRatingForProduct();
        $response = [
            'review' => [
                'customer_id' => $this->customerSession->getCustomer()->getId(),
                'product_id' => $this->getCurrentProduct()->getId(),
            ]
        ];

        if (isset($rating['id'])) {
            $response['review']['id'] =  $rating['id'];
            $response['review']['rating'] = $rating['rating'];
        }

        return $response;
    }

    private function getCurrentProduct(): ?Product
    {
        return $this->registry->registry('current_product');
    }

    public function isCustomerLoggedIn(): bool
    {
        return $this->customerSession->isLoggedIn();
    }

    private function getCustomerRatingForProduct(): ?array
    {
        $this->searchCriteriaBuilder->addFilter('customer_id', $this->customerSession->getCustomer()->getId());
        $this->searchCriteriaBuilder->addFilter('product_id', $this->getCurrentProduct()->getId());
        $sortOrder = $this->sortOrderBuilder
            ->setField('created_at')
            ->setDescendingDirection()
            ->create();
        $this->searchCriteriaBuilder->addSortOrder($sortOrder);
        $searchCriteria = $this->searchCriteriaBuilder
            ->create()
            ->setPageSize(1)
            ->setCurrentPage(1);

        $items = $this->reviewRepository->getList($searchCriteria)->getItems();

        if (is_array($items) && count($items) > 0) {
            return [
                'rating' => current($items)->getRating(),
                'id' => current($items)->getId()
            ];
        }

        return null;
    }

    public function getRating(): string
    {
        try {
            $rating = $this->serviceCalculateProductRating->calculate(
                (int)$this->getCurrentProduct()->getId()
            );
        } catch (\Exception $e) {
            $this->logger->critical('Something gone wrong');
        }

        return $rating;
    }
}
