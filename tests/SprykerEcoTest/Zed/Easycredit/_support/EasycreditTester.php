<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\Easycredit;

use Codeception\Actor;
use Orm\Zed\Country\Persistence\SpyCountry;
use Orm\Zed\Country\Persistence\SpyCountryQuery;
use Orm\Zed\Sales\Persistence\Map\SpySalesOrderAddressTableMap;
use Orm\Zed\Sales\Persistence\Map\SpySalesOrderTableMap;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Orm\Zed\Sales\Persistence\SpySalesOrderAddress;
use Orm\Zed\Sales\Persistence\SpySalesOrderTotals;

/**
 * Inherited Methods
 *
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
 */
class EasycreditTester extends Actor
{
    use _generated\EasycreditTesterActions;

    /**
     * @return int
     */
    public function createOrder(): int
    {
        $salesOrderEntity = new SpySalesOrder();

        $this->addOrderDetails($salesOrderEntity);
        $this->addAddresses($salesOrderEntity);
        $salesOrderEntity->save();

        $this->addOrderTotals($salesOrderEntity);

        return $salesOrderEntity->getIdSalesOrder();
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $salesOrderEntity
     *
     * @return void
     */
    protected function addOrderDetails(SpySalesOrder $salesOrderEntity): void
    {
        $salesOrderEntity->setOrderReference(random_int(0, 9999999));
        $salesOrderEntity->setCurrencyIsoCode('EUR');
        $salesOrderEntity->setPriceMode(null);
        $salesOrderEntity->setIsTest(true);
        $salesOrderEntity->setSalutation(SpySalesOrderTableMap::COL_SALUTATION_MR);
        $salesOrderEntity->setFirstName('FirstName');
        $salesOrderEntity->setLastName('LastName');
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $salesOrderEntity
     *
     * @return void
     */
    protected function addAddresses(SpySalesOrder $salesOrderEntity): void
    {
        $billingAddressEntity = $salesOrderEntity->getBillingAddress();
        if ($billingAddressEntity === null) {
            $billingAddressEntity = $this->createBillingAddress();
            $salesOrderEntity->setBillingAddress($billingAddressEntity);
        }

        $shippingAddressEntity = $salesOrderEntity->getShippingAddress();
        if ($shippingAddressEntity === null) {
            $salesOrderEntity->setShippingAddress($billingAddressEntity);
        }
    }

    /**
     * @return \Orm\Zed\Country\Persistence\SpyCountry
     */
    protected function getCountryEntity(): SpyCountry
    {
        $countryQuery = new SpyCountryQuery();
        $countryQuery->filterByIso2Code('DE');
        $countryQuery->filterByIso3Code('DEU');
        $countryQuery->filterByName('Germany');
        $countryQuery->filterByPostalCodeMandatory(true);
        $countryQuery->filterByPostalCodeRegex('\d{5}');

        $countryEntity = $countryQuery->findOneOrCreate();
        $countryEntity->save();

        return $countryEntity;
    }

    /**
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrderAddress
     */
    protected function createBillingAddress(): SpySalesOrderAddress
    {
        $billingAddressEntity = new SpySalesOrderAddress();

        $countryEntity = $this->getCountryEntity();
        $billingAddressEntity->setCountry($countryEntity);

        $billingAddressEntity->setSalutation(SpySalesOrderAddressTableMap::COL_SALUTATION_MR);
        $billingAddressEntity->setFirstName('FirstName');
        $billingAddressEntity->setLastName('LastName');
        $billingAddressEntity->setAddress1('Address1');
        $billingAddressEntity->setAddress2('Address2');
        $billingAddressEntity->setCity('City');
        $billingAddressEntity->setZipCode('12345');
        $billingAddressEntity->save();

        return $billingAddressEntity;
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $salesOrderEntity
     *
     * @return void
     */
    protected function addOrderTotals(SpySalesOrder $salesOrderEntity): void
    {
        $salesOrderTotals = new SpySalesOrderTotals();

        $salesOrderTotals->setFkSalesOrder($salesOrderEntity->getIdSalesOrder());
        $salesOrderTotals->setTaxTotal(10);
        $salesOrderTotals->setSubtotal(100);
        $salesOrderTotals->setDiscountTotal(10);
        $salesOrderTotals->setGrandTotal(100);

        $salesOrderTotals->save();
    }
}
