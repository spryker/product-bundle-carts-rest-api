<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ProductBundleCartsRestApi\Processor\RestResponseBuilder;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestItemsAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;

interface BundleItemRestResponseBuilderInterface
{
    public function createBundleItemResource(
        QuoteTransfer $quoteTransfer,
        ItemTransfer $itemTransfer,
        RestItemsAttributesTransfer $restItemsAttributesTransfer
    ): RestResourceInterface;

    public function createGuestBundleItemResource(
        QuoteTransfer $quoteTransfer,
        ItemTransfer $itemTransfer,
        RestItemsAttributesTransfer $restItemsAttributesTransfer
    ): RestResourceInterface;

    public function createBundledItemResource(
        ItemTransfer $bundleItemTransfer,
        RestItemsAttributesTransfer $restItemsAttributesTransfer
    ): RestResourceInterface;
}
