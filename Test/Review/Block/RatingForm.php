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

    private function getCusomerDataRequest(): array
    {
        return [
            'review' => [
                'customer_id' => $this->customerSession->getCustomer()->getId(),
                'product_id' => $this->getCurrentProduct()->getId(),
                'rating' => $this->getCustomerRatingForProduct(),
            ]
        ];
    }

    private function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }

    public function isCustomerLoggedIn(): bool
    {
        return $this->customerSession->isLoggedIn();
    }

    private function getCustomerRatingForProduct(): ?int
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

        if (is_array($items)) {
            return current($items)->getRating();
        }

        return null;
    }

    public function getRating(): ?string
    {
        $this->searchCriteriaBuilder->addFilter('product_id', $this->getCurrentProduct()->getId());
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $items = $this->reviewRepository->getList($searchCriteria)->getItems();

        if (is_array($items)) {
            $amount = count($items);
            $rating = 0;
            foreach ($items as $item) {
                $rating += (int)$item->getRating();
            }
            return sprintf('%d/%d', round($rating/$amount), 5);
        }

        return null;
    }
}
