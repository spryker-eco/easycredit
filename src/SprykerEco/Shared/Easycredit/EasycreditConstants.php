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
    /**
     * @var string
     */
    public const SUCCESS_URL = 'EASYCREDIT:SUCCESS_URL';

    /**
     * @var string
     */
    public const DENIED_URL = 'EASYCREDIT:DENIED_URL';

    /**
     * @var string
     */
    public const CANCELLED_URL = 'EASYCREDIT:CANCELLED_URL';

    /**
     * @var string
     */
    public const SHOP_IDENTIFIER = 'EASYCREDIT:SHOP_IDENTIFIER';

    /**
     * @var string
     */
    public const SHOP_TOKEN = 'EASYCREDIT:SHOP_TOKEN';

    /**
     * @var string
     */
    public const API_URL = 'EASYCREDIT:API_URL';

    /**
     * @var string
     */
    public const EASYCREDIT_EXPENSE_TYPE = 'EASYCREDIT:EASYCREDIT_EXPENSE_TYPE';
}
