<?php
require_once __DIR__ . '/ICategory.php';
//require_once __DIR__ . '/IProduct.php';
class CategoryComposite implements ICategory {
    private int $id;
    private string $name;
    private string $image;
    private ?ICategory $parentCategory;
    private array $subcategories = [];
    private array $products = [];

    public function __construct(int $id, string $name, string $image, ?ICategory $parentCategory = null) {
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
        $this->parentCategory = $parentCategory;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getImage(): string {
        return $this->image;
    }

    public function getParentCategory(): ?ICategory {
        return $this->parentCategory;
    }

    public function getSubcategories(): array {
        return $this->subcategories;
    }

    public function getProducts(): array {
        return $this->products;
    }

    public function addProduct(IProduct $product): void {
        $this->products[] = $product;
    }

    public function removeProduct(int $productId): void {
        $this->products = array_filter($this->products, fn($product) => $product->getId() !== $productId);
    }

    public function getProductById(int $productId): ?IProduct {
        foreach ($this->products as $product) {
            if ($product->getId() === $productId) {
                return $product;
            }
        }
        return null;
    }

    public function addSubcategory(ICategory $category): void {
        $this->subcategories[] = $category;
    }

    public function removeSubcategory(int $categoryId): void {
        $this->subcategories = array_filter($this->subcategories, fn($category) => $category->getId() !== $categoryId);
    }

    public function getSubcategoryById(int $categoryId): ?ICategory {
        foreach ($this->subcategories as $category) {
            if ($category->getId() === $categoryId) {
                return $category;
            }
        }
        return null;
    }
}