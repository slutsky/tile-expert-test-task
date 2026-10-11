<?php

declare(strict_types=1);

/**
 * This file ignore some php-cs-fixer rules because laminas/laminas-soap uses
 * the old annotation format.
 *
 * @php-cs-fixer-ignore fully_qualified_strict_types,no_superfluous_phpdoc_tags,no_empty_phpdoc
 */

namespace App\OrderingSoap\Dto;

class OrderBase
{
    /**
     * @var string
     */
    public protected(set) string $hash = '';

    /**
     * @var int
     */
    public protected(set) ?int $userId = null;

    /**
     * @var string
     */
    public protected(set) string $token = '';

    /**
     * @var string
     */
    public protected(set) ?string $number = null;

    /**
     * @var int
     */
    public protected(set) int $status = 1;

    /**
     * @var string
     */
    public protected(set) ?string $email = null;

    /**
     * @var int
     */
    public protected(set) int $vatType = 0;

    /**
     * @var string
     */
    public protected(set) ?string $vatNumber = null;

    /**
     * @var string
     */
    public protected(set) ?string $taxNumber = null;

    /**
     * @var int
     */
    public protected(set) ?int $discount = null;

    /**
     * @var float
     */
    public protected(set) ?float $delivery = null;

    /**
     * @var int
     */
    public protected(set) int $deliveryType = 0;

    /**
     * @var \DateTimeImmutable
     */
    public protected(set) ?\DateTimeImmutable $deliveryTimeMin = null;

    /**
     * @var \DateTimeImmutable
     */
    public protected(set) ?\DateTimeImmutable $deliveryTimeMax = null;

    /**
     * @var \DateTimeImmutable
     */
    public protected(set) ?\DateTimeImmutable $deliveryTimeConfirmMin = null;

    /**
     * @var \DateTimeImmutable
     */
    public protected(set) ?\DateTimeImmutable $deliveryTimeConfirmMax = null;

    /**
     * @var \DateTimeImmutable
     */
    public protected(set) ?\DateTimeImmutable $deliveryTimeFastPayMin = null;

    /**
     * @var \DateTimeImmutable
     */
    public protected(set) ?\DateTimeImmutable $deliveryTimeFastPayMax = null;

    /**
     * @var \DateTimeImmutable
     */
    public protected(set) ?\DateTimeImmutable $deliveryOldTimeMin = null;

    /**
     * @var \DateTimeImmutable
     */
    public protected(set) ?\DateTimeImmutable $deliveryOldTimeMax = null;

    /**
     * @var string
     */
    public protected(set) ?string $deliveryIndex = null;

    /**
     * @var int
     */
    public protected(set) ?int $deliveryCountry = null;

    /**
     * @var string
     */
    public protected(set) ?string $deliveryRegion = null;

    /**
     * @var string
     */
    public protected(set) ?string $deliveryCity = null;

    /**
     * @var string
     */
    public protected(set) ?string $deliveryAddress = null;

    /**
     * @var string
     */
    public protected(set) ?string $deliveryBuilding = null;

    /**
     * @var string
     */
    public protected(set) ?string $deliveryPhoneCode = null;

    /**
     * @var string
     */
    public protected(set) ?string $deliveryPhone = null;

    /**
     * @var int
     */
    public protected(set) ?int $sex = null;

    /**
     * @var string
     */
    public protected(set) ?string $clientName = null;

    /**
     * @var string
     */
    public protected(set) ?string $clientSurname = null;

    /**
     * @var string
     */
    public protected(set) ?string $companyName = null;

    /**
     * @var int
     */
    public protected(set) int $payType = 0;

    /**
     * @var \DateTimeImmutable
     */
    public protected(set) ?\DateTimeImmutable $payDateExecution = null;

    /**
     * @var \DateTimeImmutable
     */
    public protected(set) ?\DateTimeImmutable $offsetDate = null;

    /**
     * @var int
     */
    public protected(set) ?int $offsetReason = null;

    /**
     * @var \DateTimeImmutable
     */
    public protected(set) ?\DateTimeImmutable $proposedDate = null;

    /**
     * @var \DateTimeImmutable
     */
    public protected(set) ?\DateTimeImmutable $shipDate = null;

    /**
     * @var string
     */
    public protected(set) ?string $trackingNumber = null;

    /**
     * @var string
     */
    public protected(set) ?string $managerName = null;

    /**
     * @var string
     */
    public protected(set) ?string $managerEmail = null;

    /**
     * @var string
     */
    public protected(set) ?string $managerPhone = null;

    /**
     * @var string
     */
    public protected(set) ?string $carrierName = null;

    /**
     * @var string
     */
    public protected(set) ?string $carrierContactData = null;

    /**
     * Locale.
     *
     * This property contains quick fix to can get example request from
     * wsdl-web. As default laminas/soap no advanced validation. Better
     * to throws exception or implement custom types with restrictions.
     *
     * @var string
     */
    public protected(set) string $locale = '' {
        set => mb_strcut($value, 0, 5);
    }

    /**
     * @var float
     */
    public protected(set) ?float $curRate = null;

    /**
     * Currency.
     *
     * This property contains quick fix to can get example request from
     * wsdl-web. As default laminas/soap no advanced validation. Better
     * to throws exception or implement custom types with restrictions.
     *
     * @var string
     */
    public protected(set) string $currency = 'EUR' {
        set => mb_strcut($value, 0, 3);
    }

    /**
     * Measure.
     *
     * This property contains quick fix to can get example request from
     * wsdl-web. As default laminas/soap no advanced validation. Better
     * to throws exception or implement custom types with restrictions.
     *
     * @var string
     */
    public protected(set) string $measure = 'm' {
        set => mb_strcut($value, 0, 3);
    }

    /**
     * @var string
     */
    public protected(set) string $name = '';

    /**
     * @var string
     */
    public protected(set) ?string $description = null;

    /**
     * @var string
     */
    public protected(set) ?string $warehouseData = null;

    /**
     * @var int
     */
    public protected(set) int $step = 1;

    /**
     * @var bool
     */
    public protected(set) ?bool $addressEqual = true;

    /**
     * @var bool
     */
    public protected(set) ?bool $bankTransferRequested = null;

    /**
     * @var bool
     */
    public protected(set) ?bool $acceptPay = null;

    /**
     * @var \DateTimeImmutable
     */
    public protected(set) ?\DateTimeImmutable $cancelDate = null;

    /**
     * @var float
     */
    public protected(set) ?float $weightGross = null;

    /**
     * @var bool
     */
    public protected(set) ?bool $productReview = null;

    /**
     * @var int
     */
    public protected(set) ?int $mirror = null;

    /**
     * @var bool
     */
    public protected(set) ?bool $process = null;

    /**
     * @var \DateTimeImmutable
     */
    public protected(set) ?\DateTimeImmutable $factDate = null;

    /**
     * @var int
     */
    public protected(set) ?int $entranceReview = null;

    /**
     * @var bool
     */
    public protected(set) ?bool $paymentEuro = false;

    /**
     * @var bool
     */
    public protected(set) ?bool $specPrice = null;

    /**
     * @var bool
     */
    public protected(set) ?bool $showMsg = null;

    /**
     * @var float
     */
    public protected(set) ?float $deliveryPriceEuro = null;

    /**
     * @var int
     */
    public protected(set) ?int $addressPayer = null;

    /**
     * @var \DateTimeImmutable
     */
    public protected(set) ?\DateTimeImmutable $sendingDate = null;

    /**
     * @var int
     */
    public protected(set) ?int $deliveryCalculateType = null;

    /**
     * @var \DateTimeImmutable
     */
    public protected(set) ?\DateTimeImmutable $fullPaymentDate = null;

    /**
     * @var string
     */
    public protected(set) ?string $bankDetails = null;

    /**
     * @var string
     */
    public protected(set) ?string $deliveryApartmentOffice = null;
}
