<?php

declare(strict_types=1);

/**
 * This file ignore some php-cs-fixer rules because laminas/laminas-soap uses
 * the old annotation format.
 *
 * @php-cs-fixer-ignore fully_qualified_strict_types,no_superfluous_phpdoc_tags,no_empty_phpdoc
 */

namespace App\OrderingSoap\Dto;

use App\Ordering\Order as OrderEntity;

class Order extends OrderBase
{
    /**
     * @var int
     */
    public protected(set) int $id = 0;

    /**
     * Add 0 as not nullable default value. This is hack to generate correct WSDL file.
     *
     * @var \DateTimeImmutable
     */
    public protected(set) \DateTimeImmutable|int $createDate = 0;

    /**
     * @var \DateTimeImmutable
     */
    public protected(set) ?\DateTimeImmutable $updateDate = null;

    public function __construct()
    {
        $this->createDate = \DateTimeImmutable::createFromTimestamp(0);
    }

    public static function fromEntity(OrderEntity $entity): self
    {
        $order = new self();
        $order->id = $entity->id;
        $order->updateDate = $entity->updateDate;
        $order->hash = $entity->hash;
        $order->token = $entity->token;
        $order->payType = $entity->payType;
        $order->locale = $entity->locale;
        $order->name = $entity->name;
        $order->createDate = $entity->createDate;
        $order->userId = $entity->userId;
        $order->number = $entity->number;
        $order->status = $entity->status;
        $order->email = $entity->email;
        $order->vatType = $entity->vatType;
        $order->vatNumber = $entity->vatNumber;
        $order->taxNumber = $entity->taxNumber;
        $order->discount = $entity->discount;
        $order->delivery = $entity->delivery;
        $order->deliveryType = $entity->deliveryType;
        $order->deliveryTimeMin = $entity->deliveryTimeMin;
        $order->deliveryTimeMax = $entity->deliveryTimeMax;
        $order->deliveryTimeConfirmMin = $entity->deliveryTimeConfirmMin;
        $order->deliveryTimeConfirmMax = $entity->deliveryTimeConfirmMax;
        $order->deliveryTimeFastPayMin = $entity->deliveryTimeFastPayMin;
        $order->deliveryTimeFastPayMax = $entity->deliveryTimeFastPayMax;
        $order->deliveryOldTimeMin = $entity->deliveryOldTimeMin;
        $order->deliveryOldTimeMax = $entity->deliveryOldTimeMax;
        $order->deliveryIndex = $entity->deliveryIndex;
        $order->deliveryCountry = $entity->deliveryCountry;
        $order->deliveryRegion = $entity->deliveryRegion;
        $order->deliveryCity = $entity->deliveryCity;
        $order->deliveryAddress = $entity->deliveryAddress;
        $order->deliveryBuilding = $entity->deliveryBuilding;
        $order->deliveryPhoneCode = $entity->deliveryPhoneCode;
        $order->deliveryPhone = $entity->deliveryPhone;
        $order->sex = $entity->sex;
        $order->clientName = $entity->clientName;
        $order->clientSurname = $entity->clientSurname;
        $order->companyName = $entity->companyName;
        $order->payDateExecution = $entity->payDateExecution;
        $order->offsetDate = $entity->offsetDate;
        $order->offsetReason = $entity->offsetReason;
        $order->proposedDate = $entity->proposedDate;
        $order->shipDate = $entity->shipDate;
        $order->trackingNumber = $entity->trackingNumber;
        $order->managerName = $entity->managerName;
        $order->managerEmail = $entity->managerEmail;
        $order->managerPhone = $entity->managerPhone;
        $order->carrierName = $entity->carrierName;
        $order->carrierContactData = $entity->carrierContactData;
        $order->curRate = $entity->curRate;
        $order->currency = $entity->currency;
        $order->measure = $entity->measure;
        $order->description = $entity->description;
        $order->updateDate = $entity->updateDate;
        $order->warehouseData = $entity->warehouseData;
        $order->step = $entity->step;
        $order->addressEqual = $entity->addressEqual;
        $order->bankTransferRequested = $entity->bankTransferRequested;
        $order->acceptPay = $entity->acceptPay;
        $order->cancelDate = $entity->cancelDate;
        $order->weightGross = $entity->weightGross;
        $order->productReview = $entity->productReview;
        $order->mirror = $entity->mirror;
        $order->process = $entity->process;
        $order->factDate = $entity->factDate;
        $order->entranceReview = $entity->entranceReview;
        $order->paymentEuro = $entity->paymentEuro;
        $order->specPrice = $entity->specPrice;
        $order->showMsg = $entity->showMsg;
        $order->deliveryPriceEuro = $entity->deliveryPriceEuro;
        $order->addressPayer = $entity->addressPayer;
        $order->sendingDate = $entity->sendingDate;
        $order->deliveryCalculateType = $entity->deliveryCalculateType;
        $order->fullPaymentDate = $entity->fullPaymentDate;
        $order->bankDetails = $entity->bankDetails;
        $order->deliveryApartmentOffice = $entity->deliveryApartmentOffice;

        return $order;
    }
}
