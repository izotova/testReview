<?php declare(strict_types=1);

/**
 * Copyright © Andrii, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Test\Review\Model\ResourceModel\Review;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Test\Review\Model\ResourceModel\Review as ResourceModelReview;
use Test\Review\Model\Review as BaseModelReview;

/**
 * Review collection resource model
 *
 * @api
 *
 * @author Andrii <andrii.izotov.vlad@gmail.com>
 * @since 100.0.2
 */
class Collection extends AbstractCollection
{

    protected $_idFieldName = 'id';

    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'test_review_collection';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'review_collection';

    protected function _construct()
    {
        $this->_init(BaseModelReview::class, ResourceModelReview::class);
    }
}
