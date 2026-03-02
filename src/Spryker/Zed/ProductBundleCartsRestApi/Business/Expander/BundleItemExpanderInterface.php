<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Zed\ProductBundleCartsRestApi\Business\Expander;

use Generated\Shared\Transfer\PersistentCartChangeTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface BundleItemExpanderInterface
{
    public function expand(PersistentCartChangeTransfer $persistentCartChangeTransfer, QuoteTransfer $guestQuoteTransfer): PersistentCartChangeTransfer;
}
