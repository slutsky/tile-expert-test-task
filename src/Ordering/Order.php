<?php

declare(strict_types=1);

namespace App\Ordering;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'orders')]
#[ORM\Index(name: 'IDX_1', columns: ['delivery_country'])]
#[ORM\Index(name: 'IDX_2', columns: ['user_id'])]
#[ORM\Index(name: 'IDX_3', columns: ['create_date'])]
#[ORM\Index(name: 'IDX_4', columns: ['create_date', 'status'])]
#[ORM\Index(name: 'IDX_5', columns: ['hash'])]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'id')]
    public private(set) int $id;

    #[ORM\Column(name: 'hash', type: Types::STRING, length: 32, nullable: false, options: [
        'comment' => 'hash заказа',
    ])]
    public private(set) string $hash;

    #[ORM\Column(name: 'user_id', nullable: true)]
    public private(set) ?int $userId = null;

    #[ORM\Column(name: 'token', type: Types::STRING, length: 64, nullable: false, options: [
        'comment' => 'уникальный хеш пользователя',
    ])]
    public private(set) string $token;

    #[ORM\Column(name: 'number', type: Types::STRING, length: 10, nullable: true, options: [
        'comment' => 'Номер заказа',
    ])]
    public private(set) ?string $number = null;

    #[ORM\Column(name: 'status', nullable: false, options: [
        'default' => 1,
        'comment' => 'Статус заказа',
    ])]
    public private(set) int $status = 1;

    #[ORM\Column(name: 'email', type: Types::STRING, length: 100, nullable: true, options: [
        'comment' => 'контактный E-mail',
    ])]
    public private(set) ?string $email = null;

    #[ORM\Column(name: 'vat_type', nullable: false, options: [
        'default' => 0,
        'comment' => 'Частное лицо или плательщик НДС',
    ])]
    public private(set) int $vatType = 0;

    #[ORM\Column(name: 'vat_number', type: Types::STRING, length: 100, nullable: true, options: [
        'comment' => 'НДС-номер',
    ])]
    public private(set) ?string $vatNumber = null;

    #[ORM\Column(name: 'tax_number', type: Types::STRING, length: 50, nullable: true, options: [
        'comment' => 'Индивидуальный налоговый номер налогоплательщика',
    ])]
    public private(set) ?string $taxNumber = null;

    #[ORM\Column(name: 'discount', type: Types::SMALLINT, nullable: true, options: [
        'comment' => 'Процент скидки',
    ])]
    public private(set) ?int $discount = null;

    #[ORM\Column(name: 'delivery', nullable: true, options: [
        'comment' => 'Стоимость доставки',
    ])]
    public private(set) ?float $delivery = null;

    #[ORM\Column(name: 'delivery_type', type: Types::SMALLINT, nullable: true, options: [
        'default' => 0,
        'comment' => 'Тип доставки: 0 - адрес клинта, 1 - адрес склада',
    ])]
    public private(set) int $deliveryType = 0;

    #[ORM\Column(name: 'delivery_time_min', type: Types::DATE_IMMUTABLE, nullable: true, options: [
        'comment' => 'Минимальный срок доставки',
    ])]
    public private(set) ?\DateTimeImmutable $deliveryTimeMin = null;

    #[ORM\Column(name: 'delivery_time_max', type: Types::DATE_IMMUTABLE, nullable: true, options: [
        'comment' => 'Максимальный срок доставки',
    ])]
    public private(set) ?\DateTimeImmutable $deliveryTimeMax = null;

    #[ORM\Column(name: 'delivery_time_confirm_min', type: Types::DATE_IMMUTABLE, nullable: true, options: [
        'comment' => 'Минимальный срок доставки подтверждённый производителем',
    ])]
    public private(set) ?\DateTimeImmutable $deliveryTimeConfirmMin = null;

    #[ORM\Column(name: 'delivery_time_confirm_max', type: Types::DATE_IMMUTABLE, nullable: true, options: [
        'comment' => 'Максимальный срок доставки подтверждённый производителем',
    ])]
    public private(set) ?\DateTimeImmutable $deliveryTimeConfirmMax = null;

    #[ORM\Column(name: 'delivery_time_fast_pay_min', type: Types::DATE_IMMUTABLE, nullable: true, options: [
        'comment' => 'Минимальный срок доставки',
    ])]
    public private(set) ?\DateTimeImmutable $deliveryTimeFastPayMin = null;

    #[ORM\Column(name: 'delivery_time_fast_pay_max', type: Types::DATE_IMMUTABLE, nullable: true, options: [
        'comment' => 'Максимальный срок доставки',
    ])]
    public private(set) ?\DateTimeImmutable $deliveryTimeFastPayMax = null;

    #[ORM\Column(name: 'delivery_old_time_min', type: Types::DATE_IMMUTABLE, nullable: true, options: [
        'comment' => 'Прошлый минимальный срок доставки',
    ])]
    public private(set) ?\DateTimeImmutable $deliveryOldTimeMin = null;

    #[ORM\Column(name: 'delivery_old_time_max', type: Types::DATE_IMMUTABLE, nullable: true, options: [
        'comment' => 'Прошлый максимальный срок доставки',
    ])]
    public private(set) ?\DateTimeImmutable $deliveryOldTimeMax = null;

    #[ORM\Column(name: 'delivery_index', type: Types::STRING, length: 20, nullable: true)]
    public private(set) ?string $deliveryIndex = null;

    #[ORM\Column(name: 'delivery_country', nullable: true)]
    public private(set) ?int $deliveryCountry = null;

    #[ORM\Column(name: 'delivery_region', type: Types::STRING, length: 50, nullable: true)]
    public private(set) ?string $deliveryRegion = null;

    #[ORM\Column(name: 'delivery_city', type: Types::STRING, length: 200, nullable: true)]
    public private(set) ?string $deliveryCity = null;

    #[ORM\Column(name: 'delivery_address', type: Types::STRING, length: 300, nullable: true)]
    public private(set) ?string $deliveryAddress = null;

    #[ORM\Column(name: 'delivery_building', type: Types::STRING, length: 200, nullable: true)]
    public private(set) ?string $deliveryBuilding = null;

    #[ORM\Column(name: 'delivery_phone_code', type: Types::STRING, length: 20, nullable: true)]
    public private(set) ?string $deliveryPhoneCode = null;

    #[ORM\Column(name: 'delivery_phone', type: Types::STRING, length: 20, nullable: true)]
    public private(set) ?string $deliveryPhone = null;

    #[ORM\Column(name: 'sex', type: Types::SMALLINT, nullable: true, options: [
        'comment' => 'Пол клиента',
    ])]
    public private(set) ?int $sex = null;

    #[ORM\Column(name: 'client_name', type: Types::STRING, length: 255, nullable: true, options: [
        'comment' => 'Имя клиента',
    ])]
    public private(set) ?string $clientName = null;

    #[ORM\Column(name: 'client_surname', type: Types::STRING, length: 255, nullable: true, options: [
        'comment' => 'Фамилия клиента',
    ])]
    public private(set) ?string $clientSurname = null;

    #[ORM\Column(name: 'company_name', type: Types::STRING, length: 255, nullable: true, options: [
        'comment' => 'Название компании',
    ])]
    public private(set) ?string $companyName = null;

    #[ORM\Column(name: 'pay_type', type: Types::SMALLINT, nullable: false, options: [
        'comment' => 'Выбранный тип оплаты',
    ])]
    public private(set) int $payType;

    #[ORM\Column(name: 'pay_date_execution', type: Types::DATETIME_IMMUTABLE, nullable: true, options: [
        'comment' => 'Дата до которой действует текущая цена заказа',
    ])]
    public private(set) ?\DateTimeImmutable $payDateExecution = null;

    #[ORM\Column(name: 'offset_date', type: Types::DATETIME_IMMUTABLE, nullable: true, options: [
        'comment' => 'Дата сдвига предполагаемого расчета доставки',
    ])]
    public private(set) ?\DateTimeImmutable $offsetDate = null;

    #[ORM\Column(name: 'offset_reason', type: Types::SMALLINT, nullable: true, options: [
        'comment' => 'тип причина сдвига сроков 1 - каникулы на фабрике, 2 - фабрика уточняет сроки пр-ва, 3 - другое',
    ])]
    public private(set) ?int $offsetReason = null;

    #[ORM\Column(name: 'proposed_date', type: Types::DATETIME_IMMUTABLE, nullable: true, options: [
        'comment' => 'Предполагаемая дата поставки',
    ])]
    public private(set) ?\DateTimeImmutable $proposedDate = null;

    #[ORM\Column(name: 'ship_date', type: Types::DATETIME_IMMUTABLE, nullable: true, options: [
        'comment' => 'Предполагаемая дата отгрузки',
    ])]
    public private(set) ?\DateTimeImmutable $shipDate = null;

    #[ORM\Column(name: 'tracking_number', type: Types::STRING, length: 50, nullable: true, options: [
        'comment' => 'Номер треккинга',
    ])]
    public private(set) ?string $trackingNumber = null;

    #[ORM\Column(name: 'manager_name', type: Types::STRING, length: 20, nullable: true, options: [
        'comment' => 'Имя менеджера сопровождающего заказ',
    ])]
    public private(set) ?string $managerName = null;

    #[ORM\Column(name: 'manager_email', type: Types::STRING, length: 30, nullable: true, options: [
        'comment' => 'Email менеджера сопровождающего заказ',
    ])]
    public private(set) ?string $managerEmail = null;

    #[ORM\Column(name: 'manager_phone', type: Types::STRING, length: 20, nullable: true, options: [
        'comment' => 'Телефон менеджера сопровождающего заказ',
    ])]
    public private(set) ?string $managerPhone = null;

    #[ORM\Column(name: 'carrier_name', type: Types::STRING, length: 50, nullable: true, options: [
        'comment' => 'Название транспортной компании',
    ])]
    public private(set) ?string $carrierName = null;

    #[ORM\Column(name: 'carrier_contact_data', type: Types::STRING, length: 255, nullable: true, options: [
        'comment' => 'Контактные данные транспортной компании',
    ])]
    public private(set) ?string $carrierContactData = null;

    #[ORM\Column(name: 'locale', type: Types::STRING, length: 5, nullable: false, options: [
        'comment' => 'локаль из которой был оформлен заказ',
    ])]
    public private(set) string $locale;

    #[ORM\Column(name: 'cur_rate', type: Types::FLOAT, nullable: true, options: [
        'default' => 1,
        'comment' => 'курс на момент оплаты',
    ])]
    public private(set) ?float $curRate = null;

    #[ORM\Column(name: 'currency', type: Types::STRING, length: 3, nullable: false, options: [
        'default' => 'EUR',
        'comment' => 'валюта при которой был оформлен заказ',
    ])]
    public private(set) string $currency = 'EUR';

    #[ORM\Column(name: 'measure', type: Types::STRING, length: 3, nullable: false, options: [
        'default' => 'm',
        'comment' => 'ед. изм. в которой был оформлен заказ',
    ])]
    public private(set) string $measure = 'm';

    #[ORM\Column(name: 'name', type: Types::STRING, length: 200, nullable: false, options: [
        'comment' => 'Название заказа',
    ])]
    public private(set) string $name;

    #[ORM\Column(name: 'description', type: Types::STRING, length: 1000, nullable: true, options: [
        'comment' => 'Дополнительная информация',
    ])]
    public private(set) ?string $description = null;

    #[ORM\Column(name: 'create_date', type: Types::DATETIME_IMMUTABLE, nullable: false, options: [
        'comment' => 'Дата создания',
    ])]
    public private(set) \DateTimeImmutable $createDate;

    #[ORM\Column(name: 'update_date', type: Types::DATETIME_IMMUTABLE, nullable: true, options: [
        'comment' => 'Дата изменения',
    ])]
    public private(set) ?\DateTimeImmutable $updateDate = null;

    #[ORM\Column(name: 'warehouse_data', type: Types::TEXT, nullable: true, options: [
        'comment' => 'Данные склада: адрес, название, часы работы',
    ])]
    public private(set) ?string $warehouseData = null;

    #[ORM\Column(name: 'step', type: Types::SMALLINT, nullable: false, options: [
        'default' => 1,
        'comment' => 'если true то заказ не будет сброшен в следствии изменений',
    ])]
    public private(set) int $step = 1;

    #[ORM\Column(name: 'address_equal', type: Types::BOOLEAN, nullable: true, options: [
        'default' => true,
        'comment' => 'Адреса плательщика и получателя совпадают (false - разные, true - одинаковые )',
    ])]
    public private(set) ?bool $addressEqual = true;

    #[ORM\Column(name: 'bank_transfer_requested', type: Types::BOOLEAN, nullable: true, options: [
        'comment' => 'Запрашивался ли счет на банковский перевод',
    ])]
    public private(set) ?bool $bankTransferRequested = null;

    #[ORM\Column(name: 'accept_pay', type: Types::BOOLEAN, nullable: true, options: [
        'comment' => 'Если true то заказ отправлен в работу',
    ])]
    public private(set) ?bool $acceptPay = null;

    #[ORM\Column(name: 'cancel_date', type: Types::DATETIME_IMMUTABLE, nullable: true, options: [
        'comment' => 'Конечная дата согласования сроков поставки',
    ])]
    public private(set) ?\DateTimeImmutable $cancelDate = null;

    #[ORM\Column(name: 'weight_gross', type: Types::FLOAT, nullable: true, options: [
        'comment' => 'Общий вес брутто заказа',
    ])]
    public private(set) ?float $weightGross = null;

    #[ORM\Column(name: 'product_review', type: Types::BOOLEAN, nullable: true, options: [
        'comment' => 'Оставлен отзыв по коллекциям в заказе',
    ])]
    public private(set) ?bool $productReview = null;

    #[ORM\Column(name: 'mirror', type: Types::SMALLINT, nullable: true, options: [
        'comment' => 'Метка зеркала на котором создается заказ',
    ])]
    public private(set) ?int $mirror = null;

    #[ORM\Column(name: 'process', type: Types::BOOLEAN, nullable: true, options: [
        'comment' => 'метка массовой обработки',
    ])]
    public private(set) ?bool $process = null;

    #[ORM\Column(name: 'fact_date', type: Types::DATETIME_IMMUTABLE, nullable: true, options: [
        'comment' => 'Фактическая дата поставки',
    ])]
    public private(set) ?\DateTimeImmutable $factDate = null;

    #[ORM\Column(name: 'entrance_review', type: Types::SMALLINT, nullable: true, options: [
        'comment' => 'Фиксирует вход клиента на страницу отзыва и последующие клики',
    ])]
    public private(set) ?int $entranceReview = null;

    #[ORM\Column(name: 'payment_euro', type: Types::BOOLEAN, nullable: true, options: [
        'default' => false,
        'comment' => 'Если true, то оплату посчитать в евро',
    ])]
    public private(set) ?bool $paymentEuro = false;

    #[ORM\Column(name: 'spec_price', type: Types::BOOLEAN, nullable: true, options: [
        'comment' => 'установлена спец цена по заказу',
    ])]
    public private(set) ?bool $specPrice = null;

    #[ORM\Column(name: 'show_msg', type: Types::BOOLEAN, nullable: true, options: [
        'comment' => 'Показывать спец. сообщение',
    ])]
    public private(set) ?bool $showMsg = null;

    #[ORM\Column(name: 'delivery_price_euro', type: Types::FLOAT, nullable: true, options: [
        'comment' => 'Стоимость доставки в евро',
    ])]
    public private(set) ?float $deliveryPriceEuro = null;

    #[ORM\Column(name: 'address_payer', type: Types::INTEGER, nullable: true)]
    public private(set) ?int $addressPayer = null;

    #[ORM\Column(name: 'sending_date', type: Types::DATETIME_IMMUTABLE, nullable: true, options: [
        'comment' => 'Расчетная дата поставки',
    ])]
    public private(set) ?\DateTimeImmutable $sendingDate = null;

    #[ORM\Column(name: 'delivery_calculate_type', type: Types::SMALLINT, nullable: true, options: [
        'default' => 0,
        'comment' => 'Тип расчета: 0 - ручной, 1 - автоматический',
    ])]
    public private(set) ?int $deliveryCalculateType = null;

    #[ORM\Column(name: 'full_payment_date', type: Types::DATE_IMMUTABLE, nullable: true, options: [
        'comment' => 'Дата полной оплаты заказа',
    ])]
    public private(set) ?\DateTimeImmutable $fullPaymentDate = null;

    #[ORM\Column(name: 'bank_details', type: Types::TEXT, nullable: true, options: [
        'comment' => 'Реквизиты банка для возврата средств',
    ])]
    public private(set) ?string $bankDetails = null;

    #[ORM\Column(name: 'delivery_apartment_office', type: Types::STRING, length: 30, nullable: true, options: [
        'comment' => 'Квартира/офис',
    ])]
    public private(set) ?string $deliveryApartmentOffice = null;
}
