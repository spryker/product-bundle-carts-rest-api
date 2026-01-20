<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\ProductBundleCartsRestApi\Communication;

use Codeception\Test\Unit;
use Generated\Shared\DataBuilder\PersistentCartChangeBuilder;
use Generated\Shared\DataBuilder\QuoteBuilder;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\PersistentCartChangeTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\ProductBundleCartsRestApi\Communication\Plugin\CartsRestApi\BundleItemQuoteMergePersistentCartChangeExpanderPlugin;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group ProductBundleCartsRestApi
 * @group Communication
 * @group BundleItemQuoteMergePersistentCartChangeExpanderPluginTest
 * Add your own group annotations below this line
 */
class BundleItemQuoteMergePersistentCartChangeExpanderPluginTest extends Unit
{
    /**
     * @var \SprykerTest\Zed\ProductBundleCartsRestApi\ProductBundleCartsRestApiCommunicationTester
     */
    protected $tester;

    /**
     * @dataProvider bundleItemQuoteMergePersistentCartChangeExpanderDataProvider
     *
     * @param \Generated\Shared\Transfer\PersistentCartChangeTransfer $persistentCartChangeTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param int $expectedCount
     * @param string $message
     *
     * @return void
     */
    public function testBundleItemQuoteMergePersistentCartChangeExpanderPluginWillHandleBundleItems(
        PersistentCartChangeTransfer $persistentCartChangeTransfer,
        QuoteTransfer $quoteTransfer,
        int $expectedCount,
        string $message
    ): void {
        // Act
        $persistentCartChangeTransfer = (new BundleItemQuoteMergePersistentCartChangeExpanderPlugin())
            ->expand($persistentCartChangeTransfer, $quoteTransfer);

        // Assert
        $this->assertCount($expectedCount, $persistentCartChangeTransfer->getItems(), $message);
    }

    /**
     * @return array<array>
     */
    public function bundleItemQuoteMergePersistentCartChangeExpanderDataProvider(): array
    {
        return [
            [
                (new PersistentCartChangeBuilder())->withItem([ItemTransfer::BUNDLE_ITEM_IDENTIFIER => 'BUNDLE_SKU_1_ID'])->build(),
                (new QuoteBuilder())->withBundleItem([ItemTransfer::SKU => 'BUNDLE_SKU_1'])->build(),
                1,
                'Bundle item must be added to items array, and bundled items must be removed from item array.',
            ],
            [
                (new PersistentCartChangeBuilder())->build(),
                (new QuoteBuilder())->build(),
                0,
                'When no bundle item is not in quote, plugin must do nothing.',
            ],
        ];
    }
}
