<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ProductBundleCartsRestApi\Dependency\RestResource;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\RestItemsAttributesTransfer;

class ProductBundleCartsRestApiToCartsRestApiResourceBridge implements ProductBundleCartsRestApiToCartsRestApiResourceInterface
{
    /**
     * @var \Spryker\Glue\CartsRestApi\CartsRestApiResourceInterface
     */
    protected $cartsRestApiResource;

    /**
     * @param \Spryker\Glue\CartsRestApi\CartsRestApiResourceInterface $cartsRestApiResource
     */
    public function __construct($cartsRestApiResource)
    {
        $this->cartsRestApiResource = $cartsRestApiResource;
    }

    public function mapItemTransferToRestItemsAttributesTransfer(
        ItemTransfer $itemTransfer,
        RestItemsAttributesTransfer $restItemsAttributesTransfer,
        string $localeName
    ): RestItemsAttributesTransfer {
        return $this->cartsRestApiResource->mapItemTransferToRestItemsAttributesTransfer(
            $itemTransfer,
            $restItemsAttributesTransfer,
            $localeName,
        );
    }
}
