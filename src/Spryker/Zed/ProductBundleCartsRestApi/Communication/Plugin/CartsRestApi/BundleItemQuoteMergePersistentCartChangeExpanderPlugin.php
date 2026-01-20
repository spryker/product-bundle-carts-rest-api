<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Zed\ProductBundleCartsRestApi\Communication\Plugin\CartsRestApi;

use Generated\Shared\Transfer\PersistentCartChangeTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\CartsRestApiExtension\Dependency\Plugin\QuoteMergePersistentCartChangeExpanderPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Spryker\Zed\ProductBundleCartsRestApi\ProductBundleCartsRestApiConfig getConfig()
 * @method \Spryker\Zed\ProductBundleCartsRestApi\Business\ProductBundleCartsRestApiFacadeInterface getFacade()
 * @method \Spryker\Zed\ProductBundleCartsRestApi\Business\ProductBundleCartsRestApiBusinessFactory getBusinessFactory()
 */
class BundleItemQuoteMergePersistentCartChangeExpanderPlugin extends AbstractPlugin implements QuoteMergePersistentCartChangeExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     * - Will add QuoteTransfer::BUNDLE_ITEMS to PersistentCartChangeTransfer::ITEMS.
     * - Will remove any PersistentCartChangeTransfer::ITEMS if they have ItemTransfer::BUNDLE_ITEM_IDENTIFIER set.
     * - Will not perform modifications if QuoteTransfer::BUNDLE_ITEMS is empty.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PersistentCartChangeTransfer $persistentCartChangeTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $guestQuoteTransfer
     *
     * @return \Generated\Shared\Transfer\PersistentCartChangeTransfer
     */
    public function expand(PersistentCartChangeTransfer $persistentCartChangeTransfer, QuoteTransfer $guestQuoteTransfer): PersistentCartChangeTransfer
    {
        return $this->getBusinessFactory()->createBundleItemExpander()->expand($persistentCartChangeTransfer, $guestQuoteTransfer);
    }
}
