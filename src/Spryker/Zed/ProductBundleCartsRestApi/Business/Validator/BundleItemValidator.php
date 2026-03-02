<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductBundleCartsRestApi\Business\Validator;

use Generated\Shared\Transfer\CartItemRequestTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class BundleItemValidator implements BundleItemValidatorInterface
{
    public function validateBundleItem(
        CartItemRequestTransfer $cartItemRequestTransfer,
        QuoteTransfer $quoteTransfer
    ): bool {
        if (!$quoteTransfer->getBundleItems()->count()) {
            return false;
        }

        foreach ($quoteTransfer->getBundleItems() as $itemTransfer) {
            if ($itemTransfer->getGroupKey() === $cartItemRequestTransfer->getGroupKey()) {
                return true;
            }
        }

        return false;
    }
}
