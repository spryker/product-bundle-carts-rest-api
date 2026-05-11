<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\ProductBundleCartsRestApi\Api\Storefront\Relationship;

use Generated\Api\Storefront\BundledItemsStorefrontResource;
use Generated\Shared\Transfer\ItemTransfer;
use Spryker\ApiPlatform\Relationship\AbstractRelationshipResolver;
use Spryker\Glue\CartsRestApi\Api\Storefront\Mapper\StorefrontCartItemMapperInterface;
use Spryker\Service\Serializer\SerializerServiceInterface;

/**
 * Emits `BundledItems` sub-resources for a `BundleItems` parent. Reads the component item
 * transfers carried on the parent's internal `bundledItems` array (populated by
 * {@see CartsBundleItemsRelationshipResolver}). Mirrors the legacy
 * {@see \Spryker\Glue\ProductBundleCartsRestApi\Processor\Expander\BundledItemExpander}
 * matching on `bundleProduct.groupKey === restResource.id`.
 */
class BundleItemsBundledItemsRelationshipResolver extends AbstractRelationshipResolver
{
    public function __construct(
        protected StorefrontCartItemMapperInterface $cartItemMapper,
        protected SerializerServiceInterface $serializer,
    ) {
    }

    /**
     * @return array<\Generated\Api\Storefront\BundledItemsStorefrontResource>
     */
    protected function resolveRelationship(): array
    {
        $localeName = $this->hasLocale() ? $this->getLocale()->getLocaleNameOrFail() : '';
        $resources = [];

        foreach ($this->getParentResources() as $parent) {
            $bundledItems = $parent->bundledItems ?? [];

            foreach ($bundledItems as $itemTransfer) {
                if (!$itemTransfer instanceof ItemTransfer) {
                    continue;
                }

                $resources[] = $this->mapItemToResource($itemTransfer, $localeName);
            }
        }

        return $resources;
    }

    protected function mapItemToResource(ItemTransfer $itemTransfer, string $localeName): BundledItemsStorefrontResource
    {
        $restItemsAttributesTransfer = $this->cartItemMapper->mapItemTransferToRestItemsAttributesTransfer(
            $itemTransfer,
            $localeName,
        );

        return $this->serializer->denormalize(
            $restItemsAttributesTransfer->toArray(true, true),
            BundledItemsStorefrontResource::class,
        );
    }
}
