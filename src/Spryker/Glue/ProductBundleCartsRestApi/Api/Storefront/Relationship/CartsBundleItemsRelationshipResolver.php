<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\ProductBundleCartsRestApi\Api\Storefront\Relationship;

use ArrayObject;
use Generated\Api\Storefront\BundleItemsStorefrontResource;
use Generated\Shared\Transfer\ItemTransfer;
use Spryker\ApiPlatform\Relationship\AbstractRelationshipResolver;
use Spryker\Client\ProductBundle\ProductBundleClientInterface;
use Spryker\Glue\CartsRestApi\Api\Storefront\Mapper\StorefrontCartItemMapperInterface;
use Spryker\Service\Serializer\SerializerServiceInterface;

/**
 * Builds `BundleItems` sub-resources for a `Carts`/`GuestCarts` parent. Mirrors the legacy
 * {@see \Spryker\Glue\ProductBundleCartsRestApi\Processor\Expander\BundleItemExpander}:
 * groups the parent quote's `items` together with its `bundleItems` via
 * {@see ProductBundleClientInterface::getGroupedBundleItems()}, then emits one
 * `BundleItems` resource per bundle group (the `bundleProduct` ItemTransfer).
 *
 * Carries the bundle's component items on `BundleItemsStorefrontResource::$bundledItems`
 * so the `bundled-items` relationship resolver downstream does not need to re-group.
 */
class CartsBundleItemsRelationshipResolver extends AbstractRelationshipResolver
{
    /**
     * @uses \Spryker\Client\ProductBundle\Grouper\ProductBundleGrouper::BUNDLE_ITEMS
     */
    protected const string BUNDLE_ITEMS = 'bundleItems';

    /**
     * @uses \Spryker\Client\ProductBundle\Grouper\ProductBundleGrouper::BUNDLE_PRODUCT
     */
    protected const string BUNDLE_PRODUCT = 'bundleProduct';

    public function __construct(
        protected ProductBundleClientInterface $productBundleClient,
        protected StorefrontCartItemMapperInterface $cartItemMapper,
        protected SerializerServiceInterface $serializer,
    ) {
    }

    /**
     * @return array<\Generated\Api\Storefront\BundleItemsStorefrontResource>
     */
    protected function resolveRelationship(): array
    {
        $localeName = $this->hasLocale() ? $this->getLocale()->getLocaleNameOrFail() : '';
        $resources = [];

        foreach ($this->getParentResources() as $parent) {
            $items = $parent->items ?? [];
            $bundleItems = $parent->bundleItems ?? [];

            if ($items === [] || $bundleItems === []) {
                continue;
            }

            $groupedBundleItems = $this->productBundleClient->getGroupedBundleItems(
                new ArrayObject($items),
                new ArrayObject($bundleItems),
            );

            foreach ($groupedBundleItems as $groupedBundleItem) {
                if ($groupedBundleItem instanceof ItemTransfer) {
                    continue;
                }

                $bundleProduct = $groupedBundleItem[static::BUNDLE_PRODUCT] ?? null;

                if (!$bundleProduct instanceof ItemTransfer) {
                    continue;
                }

                $resources[] = $this->mapBundleProductToResource(
                    $bundleProduct,
                    $groupedBundleItem[static::BUNDLE_ITEMS] ?? [],
                    $localeName,
                );
            }
        }

        return $resources;
    }

    /**
     * @param array<\Generated\Shared\Transfer\ItemTransfer> $bundledItems
     */
    protected function mapBundleProductToResource(
        ItemTransfer $itemTransfer,
        array $bundledItems,
        string $localeName,
    ): BundleItemsStorefrontResource {
        $restItemsAttributesTransfer = $this->cartItemMapper->mapItemTransferToRestItemsAttributesTransfer(
            $itemTransfer,
            $localeName,
        );

        $resource = $this->serializer->denormalize(
            $restItemsAttributesTransfer->toArray(true, true),
            BundleItemsStorefrontResource::class,
        );

        $resource->bundledItems = $bundledItems;

        return $resource;
    }
}
