<?php declare(strict_types=1);
/**
 * Copyright © Andrii, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Test\Review\ViewModel;

use \Magento\Framework\View\Element\Block\ArgumentInterface;
use \Magento\Framework\Phrase;

class RatingForm implements ArgumentInterface
{
    public function getTitle(): Phrase
    {
        return __('Rating');
    }

    public function getDropdownTitle(): Phrase
    {
        return __('Please vote');
    }
}
