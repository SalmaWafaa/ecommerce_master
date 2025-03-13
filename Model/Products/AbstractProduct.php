<?php
require_once 'C:\xampp\htdocs\ecommerce_master\Model\Products\IProduct.php';

abstract class AbstractProduct implements IProduct {
    protected int $id;
    protected string $name;
    protected array $colors;
    protected array $sizes;
    protected array $images;
    protected float $rate;
    protected array $reviews;
    protected int $quantity;
    protected float $salePercentage;
    protected float $cost;

    public function __construct(
        int $id,
        string $name,
        array $colors,
        array $sizes,
        array $images,
        float $rate,
        array $reviews,
        int $quantity,
        float $salePercentage,
        float $cost
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->colors = $colors;
        $this->sizes = $sizes;
        $this->images = $images;
        $this->rate = $rate;
        $this->reviews = $reviews;
        $this->quantity = $quantity;
        $this->salePercentage = $salePercentage;
        $this->cost = $cost;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getColors(): array {
        return $this->colors;
    }

    public function getSizes(): array {
        return $this->sizes;
    }

    public function getImages(): array {
        return $this->images;
    }

    public function getRate(): float {
        return $this->rate;
    }

    public function getReviews(): array {
        return $this->reviews;
    }

    public function getQuantity(): int {
        return $this->quantity;
    }

    public function getSalePercentage(): float {
        return $this->salePercentage;
    }

    public function getCost(): float {
        return $this->cost;
    }

    public function getPrice(): float {
        return $this->cost - ($this->cost * $this->salePercentage / 100);
    }

    // public function addReview(Review $review): void {
    //     $this->reviews[] = $review;
    // }

    public function removeReview(int $reviewId): void {
        $this->reviews = array_filter($this->reviews, fn($review) => $review->getId() !== $reviewId);
    }

    public function updateStock(int $quantity): void {
        $this->quantity = $quantity;
    }
}