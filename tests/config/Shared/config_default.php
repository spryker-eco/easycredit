<?php
/**
 * Copyright © 2021-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Shared\Propel\PropelConstants;
use Spryker\Zed\Propel\PropelConfig;
use SprykerEco\Shared\Easycredit\EasycreditConstants;

$config[KernelConstants::ENABLE_CONTAINER_OVERRIDING] = true;
$config[KernelConstants::PROJECT_NAMESPACE] = 'Pyz';
$config[KernelConstants::PROJECT_NAMESPACES] = [
    'Pyz',
];
$config[KernelConstants::CORE_NAMESPACES] = [
    'Spryker',
];
$config[PropelConstants::ZED_DB_ENGINE]
    = strtolower(getenv('SPRYKER_DB_ENGINE') ?: '') ?: PropelConfig::DB_ENGINE_MYSQL;
$config[PropelConstants::ZED_DB_HOST] = getenv('DATABASE_HOST');
$config[PropelConstants::ZED_DB_PORT] = getenv('DATABASE_PORT');
$config[PropelConstants::ZED_DB_USERNAME] = getenv('DATABASE_USERNAME');
$config[PropelConstants::ZED_DB_PASSWORD] = getenv('DATABASE_PASSWORD');
$config[PropelConstants::ZED_DB_DATABASE] = getenv('DATABASE_NAME');
$config['ERROR_LEVEL'] = 0;
$config[EasycreditConstants::SHOP_IDENTIFIER] = '';
$config[EasycreditConstants::SHOP_TOKEN] = '';
$config[EasycreditConstants::API_URL] = 'https://ratenkauf.easycredit.de/ratenkauf-ws/rest/v2';
$config[EasycreditConstants::REDIRECT_URL] = 'https://ratenkauf.easycredit.de/ratenkauf/content/intern/einstieg.jsf?vorgangskennung=';
$config[ApplicationConstants::BASE_URL_YVES] = 'http://yves.de.spryker.local/';
$config[EasycreditConstants::SUCCESS_URL] = $config[ApplicationConstants::BASE_URL_YVES] . '/easycredit/payment/success';
$config[EasycreditConstants::CANCELLED_URL] = $config[ApplicationConstants::BASE_URL_YVES] . '/checkout/payment';
$config[EasycreditConstants::DENIED_URL] = $config[ApplicationConstants::BASE_URL_YVES] . '/checkout/payment';
