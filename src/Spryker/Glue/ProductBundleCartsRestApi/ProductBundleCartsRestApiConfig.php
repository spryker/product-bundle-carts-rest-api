<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ProductBundleCartsRestApi;

use Spryker\Glue\Kernel\AbstractBundleConfig;

class ProductBundleCartsRestApiConfig extends AbstractBundleConfig
{
    public const RESOURCE_BUNDLE_ITEMS = 'bundle-items';
    public const RESOURCE_BUNDLED_ITEMS = 'bundled-items';

    /**
     * @uses \Spryker\Glue\CartsRestApi\CartsRestApiConfig::RESOURCE_CARTS
     */
    public const RESOURCE_CARTS = 'carts';

    /**
     * @uses \Spryker\Glue\CartsRestApi\CartsRestApiConfig::RESOURCE_CART_ITEMS
     */
    public const RESOURCE_CART_ITEMS = 'items';

    /**
     * @uses \Spryker\Glue\CartsRestApi\CartsRestApiConfig::RESOURCE_GUEST_CARTS
     */
    public const RESOURCE_GUEST_CARTS = 'guest-carts';

    /**
     * @uses \Spryker\Glue\CartsRestApi\CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS
     */
    public const RESOURCE_GUEST_CARTS_ITEMS = 'guest-cart-items';
}
