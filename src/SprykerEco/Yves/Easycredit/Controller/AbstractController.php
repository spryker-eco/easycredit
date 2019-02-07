<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Easycredit\Controller;

use Spryker\Yves\Kernel\Controller\AbstractController as SprykerAbstractController;

abstract class AbstractController extends SprykerAbstractController
{
    /**
     * @var array
     */
    protected $responseArray;

    /**
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->responseArray = $this->getApplication()['request']->query->all();
    }
}
