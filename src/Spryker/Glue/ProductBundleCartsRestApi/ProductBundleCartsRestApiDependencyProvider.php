<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ProductBundleCartsRestApi;

use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;
use Spryker\Glue\ProductBundleCartsRestApi\Dependency\Client\ProductBundleCartsRestApiToProductBundleClientBridge;
use Spryker\Glue\ProductBundleCartsRestApi\Dependency\RestResource\ProductBundleCartsRestApiToCartsRestApiResourceBridge;

/**
 * @method \Spryker\Glue\ProductBundleCartsRestApi\ProductBundleCartsRestApiConfig getConfig()
 */
class ProductBundleCartsRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_PRODUCT_BUNDLE = 'CLIENT_PRODUCT_BUNDLE';

    /**
     * @var string
     */
    public const RESOURCE_CARTS_REST_API = 'RESOURCE_CARTS_REST_API';

    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);

        $container = $this->addProductBundleClient($container);
        $container = $this->addCartsRestApiResource($container);

        return $container;
    }

    protected function addProductBundleClient(Container $container): Container
    {
        $container->set(static::CLIENT_PRODUCT_BUNDLE, function (Container $container) {
            return new ProductBundleCartsRestApiToProductBundleClientBridge(
                $container->getLocator()->productBundle()->client(),
            );
        });

        return $container;
    }

    protected function addCartsRestApiResource(Container $container): Container
    {
        $container->set(static::RESOURCE_CARTS_REST_API, function (Container $container) {
            return new ProductBundleCartsRestApiToCartsRestApiResourceBridge(
                $container->getLocator()->cartsRestApi()->resource(),
            );
        });

        return $container;
    }
}
