<?php

declare(strict_types=1);

namespace App\Ordering;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'orders_article')]
#[ORM\Index(name: 'IDX_318C0B7C7294869C', columns: ['article_id'])]
#[ORM\Index(name: 'IDX_318C0B7C7FC358ED', columns: ['orders_id'])]
class OrderArticle
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'id')]
    public private(set) int $id;

    #[ORM\Column(name: 'orders_id', nullable: true)]
    public private(set) ?int $orderId = null;

    #[ORM\Column(name: 'article_id', nullable: true, options: [
        'comment' => 'ID коллекции',
    ])]
    public private(set) ?int $articleId = null;

    #[ORM\Column(name: 'amount', nullable: false, options: [
        'comment' => 'количество артикулов в ед. измерения',
    ])]
    public private(set) float $amount;

    #[ORM\Column(name: 'price', nullable: false, options: [
        'comment' => 'Цена на момент оплаты заказа',
    ])]
    public private(set) float $price;

    #[ORM\Column(name: 'price_eur', nullable: true, options: [
        'comment' => 'Цена в Евро по заказу',
    ])]
    public private(set) ?float $priceEur = null;

    #[ORM\Column(name: 'currency', type: Types::STRING, length: 3, nullable: true, options: [
        'comment' => 'Валюта для которой установлена цена',
    ])]
    public private(set) ?string $currency = null;

    #[ORM\Column(name: 'measure', type: Types::STRING, length: 2, nullable: true, options: [
        'comment' => 'Ед. изм. для которой установлена цена',
    ])]
    public private(set) ?string $measure = null;

    #[ORM\Column(name: 'delivery_time_min', type: Types::DATE_IMMUTABLE, nullable: true, options: [
        'comment' => 'Минимальный срок доставки',
    ])]
    public private(set) ?\DateTimeImmutable $deliveryTimeMin = null;

    #[ORM\Column(name: 'delivery_time_max', type: Types::DATE_IMMUTABLE, nullable: true, options: [
        'comment' => 'Максимальный срок доставки',
    ])]
    public private(set) ?\DateTimeImmutable $deliveryTimeMax = null;

    #[ORM\Column(name: 'weight', nullable: false, options: [
        'comment' => 'вес упаковки',
    ])]
    public private(set) float $weight;

    #[ORM\Column(name: 'multiple_pallet', type: Types::SMALLINT, nullable: true, options: [
        'comment' => 'Кратность палете, 1 - кратно упаковке, 2 - кратно палете, 3 - не меньше палеты',
    ])]
    public private(set) ?int $multiplePallet = null;

    #[ORM\Column(name: 'packaging_count', nullable: false, options: [
        'comment' => 'Количество кратно которому можно добавлять товар в заказ',
    ])]
    public private(set) float $packagingCount;

    #[ORM\Column(name: 'pallet', nullable: false, options: [
        'comment' => 'количество в палете на момент заказа',
    ])]
    public private(set) float $pallet;

    #[ORM\Column(name: 'packaging', nullable: false, options: [
        'comment' => 'количество в упаковке',
    ])]
    public private(set) float $packaging;

    #[ORM\Column(name: 'swimming_pool', type: Types::BOOLEAN, nullable: false, options: [
        'default' => false,
        'comment' => 'Плитка специально для бассейна',
    ])]
    public private(set) bool $swimmingPool = false;

    public function __construct(
        float $amount,
        float $price,
        float $weight,
        float $packagingCount,
        float $pallet,
        float $packaging,
        ?int $orderId = null,
        ?int $articleId = null,
        ?float $priceEur = null,
        ?string $currency = null,
        ?string $measure = null,
        ?\DateTimeImmutable $deliveryTimeMin = null,
        ?\DateTimeImmutable $deliveryTimeMax = null,
        ?int $multiplePallet = null,
        bool $swimmingPool = false,
    ) {
        $this->orderId = $orderId;
        $this->articleId = $articleId;
        $this->amount = $amount;
        $this->price = $price;
        $this->priceEur = $priceEur;
        $this->currency = $currency;
        $this->measure = $measure;
        $this->deliveryTimeMin = $deliveryTimeMin;
        $this->deliveryTimeMax = $deliveryTimeMax;
        $this->weight = $weight;
        $this->multiplePallet = $multiplePallet;
        $this->packagingCount = $packagingCount;
        $this->pallet = $pallet;
        $this->packaging = $packaging;
        $this->swimmingPool = $swimmingPool;
    }
}
