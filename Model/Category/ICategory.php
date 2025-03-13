<?php

interface ICategory {
    public function getId(): int;
    public function getName(): string;
    public function getImage(): string;
    public function getParentCategory(): ?ICategory;
    public function getSubcategories(): array;
    public function getProducts(): array;
    public function addProduct(IProduct $product): void;
    public function removeProduct(int $productId): void;
    public function getProductById(int $productId): ?IProduct;
    public function addSubcategory(ICategory $category): void;
    public function removeSubcategory(int $categoryId): void;
    public function getSubcategoryById(int $categoryId): ?ICategory;
}