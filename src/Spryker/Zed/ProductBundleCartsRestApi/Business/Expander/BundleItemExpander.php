<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Zed\ProductBundleCartsRestApi\Business\Expander;

use Generated\Shared\Transfer\PersistentCartChangeTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class BundleItemExpander implements BundleItemExpanderInterface
{
    public function expand(PersistentCartChangeTransfer $persistentCartChangeTransfer, QuoteTransfer $guestQuoteTransfer): PersistentCartChangeTransfer
    {
        if (!$guestQuoteTransfer->getBundleItems()->count()) {
            return $persistentCartChangeTransfer;
        }

        foreach ($persistentCartChangeTransfer->getItems() as $itemIndex => $itemTransfer) {
            if (!$itemTransfer->getBundleItemIdentifier()) {
                continue;
            }

            $persistentCartChangeTransfer->getItems()->offsetUnset($itemIndex);
        }

        foreach ($guestQuoteTransfer->getBundleItems() as $bundleItemTransfer) {
            $persistentCartChangeTransfer->addItem($bundleItemTransfer);
        }

        return $persistentCartChangeTransfer;
    }
}
