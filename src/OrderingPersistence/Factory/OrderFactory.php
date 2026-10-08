<?php

declare(strict_types=1);

namespace App\OrderingPersistence\Factory;

use App\Ordering\Order;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<Order>
 */
final class OrderFactory extends PersistentObjectFactory
{
    public static function class(): string
    {
        return Order::class;
    }

    protected function defaults(): array|callable
    {
        $now = \DateTimeImmutable::createFromMutable(self::faker()->dateTimeThisCentury());

        $deliveryTimeMin = $now->add(\DateInterval::createFromDateString('+1 days'));
        $deliveryTimeMax = $now->add(\DateInterval::createFromDateString(
            sprintf('+%d days', self::faker()->numberBetween(2, 7)),
        ));

        return [
            'hash' => self::faker()->md5(),
            'userId' => self::faker()->numberBetween(1000, 100000),
            'token' => self::faker()->md5(),
            'number' => self::faker()->bothify('???-######'),
            'status' => 1,
            'email' => self::faker()->email(),
            'vatType' => 0,
            'vatNumber' => self::faker()->numerify('DE#########'),
            'taxNumber' => self::faker()->numerify('DE#########'),
            'discount' => self::faker()->numberBetween(0, 10),
            'delivery' => self::faker()->randomFloat(2, 0, 10),
            'deliveryType' => self::faker()->numberBetween(0, 1),
            'deliveryTimeMin' => $deliveryTimeMin,
            'deliveryTimeMax' => $deliveryTimeMax,
            'deliveryTimeConfirmMin' => $deliveryTimeMin,
            'deliveryTimeConfirmMax' => $deliveryTimeMax,
            'deliveryTimeFastPayMin' => $deliveryTimeMin,
            'deliveryTimeFastPayMax' => $deliveryTimeMax,
            'deliveryOldTimeMin' => null,
            'deliveryOldTimeMax' => null,
            'deliveryIndex' => self::faker()->bothify('???-??-######-######'),
            'deliveryCountry' => self::faker()->numberBetween(1000, 100000),
            'deliveryRegion' => self::faker()->city(), // `state()` method not found
            'deliveryCity' => self::faker()->city(),
            'deliveryAddress' => self::faker()->address(),
            'deliveryBuilding' => self::faker()->buildingNumber(),
            'deliveryPhoneCode' => '0049',
            'deliveryPhone' => self::faker()->phoneNumber(),
            'sex' => self::faker()->numberBetween(0, 1),
            'clientName' => self::faker()->firstName(),
            'clientSurname' => self::faker()->lastName(),
            'companyName' => self::faker()->company(),
            'payType' => self::faker()->numberBetween(0, 3),
            'payDateExecution' => $deliveryTimeMax,
            'offsetDate' => $deliveryTimeMax,
            'offsetReason' => self::faker()->numberBetween(1, 3),
            'proposedDate' => $now,
            'shipDate' => $now,
            'trackingNumber' => self::faker()->numerify('LM#########DE'),
            'managerName' => mb_strcut(self::faker()->name(), 0, 20),
            'managerEmail' => mb_strcut(self::faker()->email(), 0, 30),
            'managerPhone' => self::faker()->phoneNumber(),
            'carrierName' => self::faker()->name(),
            'carrierContactData' => self::faker()->phoneNumber(),
            'locale' => mb_substr(self::faker()->locale(), 0, 5),
            'curRate' => 1,
            'currency' => self::faker()->randomElement(['EUR', 'USD']),
            'measure' => 'm',
            'name' => self::faker()->sentence(3),
            'description' => self::faker()->paragraph(3),
            'createDate' => $now,
            'updateDate' => $now,
            'warehouseData' => self::faker()->address(),
            'step' => 0,
            'addressEqual' => self::faker()->randomElement([true, false, null]),
            'bankTransferRequested' => self::faker()->randomElement([true, false, null]),
            'acceptPay' => self::faker()->randomElement([true, false, null]),
            'cancelDate' => $deliveryTimeMax,
            'weightGross' => self::faker()->randomFloat(2, 10, 100),
            'productReview' => self::faker()->randomElement([true, false, null]),
            'mirror' => self::faker()->randomElement([1, 0, null]),
            'process' => self::faker()->randomElement([true, false, null]),
            'factDate' => $deliveryTimeMax,
            'entranceReview' => self::faker()->randomElement([1, 0, null]),
            'paymentEuro' => self::faker()->randomElement([true, false]),
            'specPrice' => self::faker()->randomElement([true, false, null]),
            'showMsg' => self::faker()->randomElement([true, false, null]),
            'deliveryPriceEuro' => self::faker()->randomFloat(2, 10, 100),
            'addressPayer' => self::faker()->numberBetween(1000, 100000),
            'sendingDate' => $deliveryTimeMin,
            'deliveryCalculateType' => self::faker()->numberBetween(0, 1),
            'fullPaymentDate' => $deliveryTimeMax,
            'bankDetails' => self::faker()->address(),
            'deliveryApartmentOffice' => mb_strcut(self::faker()->address(), 0, 30),
        ];
    }
}
