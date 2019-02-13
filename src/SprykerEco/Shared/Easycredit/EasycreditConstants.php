<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Shared\Easycredit;

/**
 * Declares global environment configuration keys. Do not use it for other class constants.
 */
interface EasycreditConstants
{
    public const SUCCESS_URL = 'EASYCREDIT:SUCCESS_URL';
    public const DENIED_URL = 'EASYCREDIT:DENIED_URL';
    public const CANCELLED_URL = 'EASYCREDIT:CANCELLED_URL';

    public const SHOP_IDENTIFIER = 'EASYCREDIT:SHOP_IDENTIFIER';
    public const SHOP_TOKEN = 'EASYCREDIT:SHOP_TOKEN';

    public const API_URL = 'EASYCREDIT:API_URL';

    public const EASYCREDIT_EXPENSE_TYPE = 'EASYCREDIT_EXPENSE_TYPE:EASYCREDIT_EXPENSE_TYPE';
}
