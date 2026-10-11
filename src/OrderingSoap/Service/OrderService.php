<?php

declare(strict_types=1);

/**
 * This file ignore some php-cs-fixer rules because laminas/laminas-soap uses
 * the old annotation format.
 *
 * @php-cs-fixer-ignore fully_qualified_strict_types,no_superfluous_phpdoc_tags,no_empty_phpdoc
 */

namespace App\OrderingSoap\Service;

use App\Ordering;
use App\OrderingSoap\Dto\Order;
use App\OrderingSoap\Dto\OrderCreate;
use App\OrderingSoap\Dto\OrderUpdate;

class OrderService
{
    public function __construct(
        private readonly Ordering\OrderService $orderService,
        private readonly Ordering\OrderRepositoryInterface $orderRepository,
    ) {
    }

    /**
     * @param \App\OrderingSoap\Dto\OrderCreate $orderCreate
     *
     * @return \App\OrderingSoap\Dto\Order
     */
    public function createOrder(OrderCreate $orderCreate): Order
    {
        $order = $this->orderService->createOrder(
            $orderCreate->hash,
            $orderCreate->name,
            $orderCreate->token,
            $orderCreate->payType,
            $orderCreate->locale,
            $orderCreate->userId,
            $orderCreate->number,
            $orderCreate->status,
            $orderCreate->email,
            $orderCreate->vatType,
            $orderCreate->vatNumber,
            $orderCreate->taxNumber,
            $orderCreate->discount,
            $orderCreate->delivery,
            $orderCreate->deliveryType,
            $orderCreate->deliveryTimeMin,
            $orderCreate->deliveryTimeMax,
            $orderCreate->deliveryTimeConfirmMin,
            $orderCreate->deliveryTimeConfirmMax,
            $orderCreate->deliveryTimeFastPayMin,
            $orderCreate->deliveryTimeFastPayMax,
            $orderCreate->deliveryOldTimeMin,
            $orderCreate->deliveryOldTimeMax,
            $orderCreate->deliveryIndex,
            $orderCreate->deliveryCountry,
            $orderCreate->deliveryRegion,
            $orderCreate->deliveryCity,
            $orderCreate->deliveryAddress,
            $orderCreate->deliveryBuilding,
            $orderCreate->deliveryPhoneCode,
            $orderCreate->deliveryPhone,
            $orderCreate->sex,
            $orderCreate->clientName,
            $orderCreate->clientSurname,
            $orderCreate->companyName,
            $orderCreate->payDateExecution,
            $orderCreate->offsetDate,
            $orderCreate->offsetReason,
            $orderCreate->proposedDate,
            $orderCreate->shipDate,
            $orderCreate->trackingNumber,
            $orderCreate->managerName,
            $orderCreate->managerEmail,
            $orderCreate->managerPhone,
            $orderCreate->carrierName,
            $orderCreate->carrierContactData,
            $orderCreate->curRate,
            $orderCreate->currency,
            $orderCreate->measure,
            $orderCreate->description,
            $orderCreate->warehouseData,
            $orderCreate->step,
            $orderCreate->addressEqual,
            $orderCreate->bankTransferRequested,
            $orderCreate->acceptPay,
            $orderCreate->cancelDate,
            $orderCreate->weightGross,
            $orderCreate->productReview,
            $orderCreate->mirror,
            $orderCreate->process,
            $orderCreate->factDate,
            $orderCreate->entranceReview,
            $orderCreate->paymentEuro,
            $orderCreate->specPrice,
            $orderCreate->showMsg,
            $orderCreate->deliveryPriceEuro,
            $orderCreate->addressPayer,
            $orderCreate->sendingDate,
            $orderCreate->deliveryCalculateType,
            $orderCreate->fullPaymentDate,
            $orderCreate->bankDetails,
            $orderCreate->deliveryApartmentOffice,
        );

        return Order::fromEntity($order);
    }

    /**
     * @param \App\OrderingSoap\Dto\OrderUpdate $orderUpdate
     *
     * @return \App\OrderingSoap\Dto\Order
     *
     * @throws \App\Ordering\OrderNotFoundException
     */
    public function updateOrder(OrderUpdate $orderUpdate): Order
    {
        $order = $this->orderRepository->getById($orderUpdate->id);

        $this->orderService->updateOrder(
            $order,
            $orderUpdate->hash,
            $orderUpdate->name,
            $orderUpdate->token,
            $orderUpdate->payType,
            $orderUpdate->locale,
            $orderUpdate->userId,
            $orderUpdate->number,
            $orderUpdate->status,
            $orderUpdate->email,
            $orderUpdate->vatType,
            $orderUpdate->vatNumber,
            $orderUpdate->taxNumber,
            $orderUpdate->discount,
            $orderUpdate->delivery,
            $orderUpdate->deliveryType,
            $orderUpdate->deliveryTimeMin,
            $orderUpdate->deliveryTimeMax,
            $orderUpdate->deliveryTimeConfirmMin,
            $orderUpdate->deliveryTimeConfirmMax,
            $orderUpdate->deliveryTimeFastPayMin,
            $orderUpdate->deliveryTimeFastPayMax,
            $orderUpdate->deliveryOldTimeMin,
            $orderUpdate->deliveryOldTimeMax,
            $orderUpdate->deliveryIndex,
            $orderUpdate->deliveryCountry,
            $orderUpdate->deliveryRegion,
            $orderUpdate->deliveryCity,
            $orderUpdate->deliveryAddress,
            $orderUpdate->deliveryBuilding,
            $orderUpdate->deliveryPhoneCode,
            $orderUpdate->deliveryPhone,
            $orderUpdate->sex,
            $orderUpdate->clientName,
            $orderUpdate->clientSurname,
            $orderUpdate->companyName,
            $orderUpdate->payDateExecution,
            $orderUpdate->offsetDate,
            $orderUpdate->offsetReason,
            $orderUpdate->proposedDate,
            $orderUpdate->shipDate,
            $orderUpdate->trackingNumber,
            $orderUpdate->managerName,
            $orderUpdate->managerEmail,
            $orderUpdate->managerPhone,
            $orderUpdate->carrierName,
            $orderUpdate->carrierContactData,
            $orderUpdate->curRate,
            $orderUpdate->currency,
            $orderUpdate->measure,
            $orderUpdate->description,
            $orderUpdate->warehouseData,
            $orderUpdate->step,
            $orderUpdate->addressEqual,
            $orderUpdate->bankTransferRequested,
            $orderUpdate->acceptPay,
            $orderUpdate->cancelDate,
            $orderUpdate->weightGross,
            $orderUpdate->productReview,
            $orderUpdate->mirror,
            $orderUpdate->process,
            $orderUpdate->factDate,
            $orderUpdate->entranceReview,
            $orderUpdate->paymentEuro,
            $orderUpdate->specPrice,
            $orderUpdate->showMsg,
            $orderUpdate->deliveryPriceEuro,
            $orderUpdate->addressPayer,
            $orderUpdate->sendingDate,
            $orderUpdate->deliveryCalculateType,
            $orderUpdate->fullPaymentDate,
            $orderUpdate->bankDetails,
            $orderUpdate->deliveryApartmentOffice,
        );

        return Order::fromEntity($order);
    }
}
