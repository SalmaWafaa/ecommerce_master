<?php

interface IProduct {
    public function getId(): int;
    public function getName(): string;
    public function getColors(): array;
    public function getSizes(): array;
    public function getImages(): array;
    public function getRate(): float;
    public function getReviews(): array;
    public function getQuantity(): int;
    public function getSalePercentage(): float;
    public function getCost(): float;
    public function getDescription(): string;
    public function getPrice(): float;
   // public function addReview(Review $review): void;
    public function removeReview(int $reviewId): void;
    public function updateStock(int $quantity): void;
}