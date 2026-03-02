<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ProductBundleCartsRestApi\Processor\RestResponseBuilder;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestItemsAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestLinkInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\ProductBundleCartsRestApi\ProductBundleCartsRestApiConfig;

class BundleItemRestResponseBuilder implements BundleItemRestResponseBuilderInterface
{
    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    public function __construct(RestResourceBuilderInterface $restResourceBuilder)
    {
        $this->restResourceBuilder = $restResourceBuilder;
    }

    public function createBundleItemResource(
        QuoteTransfer $quoteTransfer,
        ItemTransfer $itemTransfer,
        RestItemsAttributesTransfer $restItemsAttributesTransfer
    ): RestResourceInterface {
        $bundleItemRestResource = $this->restResourceBuilder->createRestResource(
            ProductBundleCartsRestApiConfig::RESOURCE_BUNDLE_ITEMS,
            $itemTransfer->getGroupKey(),
            $restItemsAttributesTransfer,
        );
        $bundleItemRestResource->setPayload($quoteTransfer);

        $bundleItemSelfLink = sprintf(
            '%s/%s/%s/%s/',
            ProductBundleCartsRestApiConfig::RESOURCE_CARTS,
            $quoteTransfer->getUuid(),
            ProductBundleCartsRestApiConfig::RESOURCE_CART_ITEMS,
            $itemTransfer->getGroupKey(),
        );

        return $bundleItemRestResource->addLink(RestLinkInterface::LINK_SELF, $bundleItemSelfLink);
    }

    public function createGuestBundleItemResource(
        QuoteTransfer $quoteTransfer,
        ItemTransfer $itemTransfer,
        RestItemsAttributesTransfer $restItemsAttributesTransfer
    ): RestResourceInterface {
        $bundleItemRestResource = $this->restResourceBuilder->createRestResource(
            ProductBundleCartsRestApiConfig::RESOURCE_BUNDLE_ITEMS,
            $itemTransfer->getGroupKey(),
            $restItemsAttributesTransfer,
        );
        $bundleItemRestResource->setPayload($quoteTransfer);

        $bundleItemSelfLink = sprintf(
            '%s/%s/%s/%s/',
            ProductBundleCartsRestApiConfig::RESOURCE_GUEST_CARTS,
            $quoteTransfer->getUuid(),
            ProductBundleCartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
            $itemTransfer->getGroupKey(),
        );

        return $bundleItemRestResource->addLink(RestLinkInterface::LINK_SELF, $bundleItemSelfLink);
    }

    public function createBundledItemResource(
        ItemTransfer $bundleItemTransfer,
        RestItemsAttributesTransfer $restItemsAttributesTransfer
    ): RestResourceInterface {
        return $this->restResourceBuilder->createRestResource(
            ProductBundleCartsRestApiConfig::RESOURCE_BUNDLED_ITEMS,
            $bundleItemTransfer->getGroupKey(),
            $restItemsAttributesTransfer,
        );
    }
}
