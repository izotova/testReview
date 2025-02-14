<?php declare(strict_types=1);
/**
 * Copyright © Andrii, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Test\Review\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Review resource model
 *
 * @api
 *
 * @author Andrii <andrii.izotov.vlad@gmail.com>
 * @since 100.0.2
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Review extends AbstractDb
{
    protected function _construct(): void
    {
        $this->_init('vendor_review', 'id');
    }
}
