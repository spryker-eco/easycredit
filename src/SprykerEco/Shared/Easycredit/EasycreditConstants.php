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
     * @api
     *
     * @var string
     */
    public const SUCCESS_URL = 'EASYCREDIT:SUCCESS_URL';

    /**
     * @api
     *
     * @var string
     */
    public const DENIED_URL = 'EASYCREDIT:DENIED_URL';

    /**
     * @api
     *
     * @var string
     */
    public const CANCELLED_URL = 'EASYCREDIT:CANCELLED_URL';

    /**
     * @api
     *
     * @var string
     */
    public const SHOP_IDENTIFIER = 'EASYCREDIT:SHOP_IDENTIFIER';

    /**
     * @api
     *
     * @var string
     */
    public const SHOP_TOKEN = 'EASYCREDIT:SHOP_TOKEN';

    /**
     * @api
     *
     * @var string
     */
    public const API_URL = 'EASYCREDIT:API_URL';

    /**
     * @api
     *
     * @var string
     */
    public const REDIRECT_URL = 'EASYCREDIT:REDIRECT_URL';

    /**
     * @api
     *
     * @var string
     */
    public const EASYCREDIT_EXPENSE_TYPE = 'EASYCREDIT:EASYCREDIT_EXPENSE_TYPE';
}
