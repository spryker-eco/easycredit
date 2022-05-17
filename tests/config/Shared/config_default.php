<?php
/**
 * Copyright © 2021-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Shared\Propel\PropelConstants;
use Spryker\Zed\Propel\PropelConfig;

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
$config[PropelConstants::ZED_DB_HOST] = getenv('DATABASE_HOST') ?: '127.0.0.1';
$config[PropelConstants::ZED_DB_PORT] = getenv('DATABASE_PORT') ?: '3306';
$config[PropelConstants::ZED_DB_USERNAME] = getenv('DATABASE_USERNAME') ?: 'root';
$config[PropelConstants::ZED_DB_PASSWORD] = getenv('DATABASE_PASSWORD') ?: 'secret';
$config[PropelConstants::ZED_DB_DATABASE] = getenv('DATABASE_NAME') ?: 'eu-docker';
$config['ERROR_LEVEL'] = 0;
