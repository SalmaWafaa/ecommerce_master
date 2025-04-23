<?php

require_once __DIR__ . '/../../config/dbConnectionSingelton.php';
require_once __DIR__ . '/ICategory.php';

class CategoryComposite implements ICategory {
    protected $conn;
    protected $table = 'categories';

    public $id;
    public $name;
    public $image;
    public $parent_id;
    public $subcategories = [];
    public $products = [];

    public function __construct() {
        $dbConnection = Database::getInstance();
        $this->conn = $dbConnection->getConnection(); // Must return a PDO instance
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
        if ($this->parent_id) {
            $query = "SELECT * FROM {$this->table} WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$this->parent_id]);
            $parentData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($parentData) {
                $parentCategory = new CategoryComposite();
                $parentCategory->id = $parentData['id'];
                $parentCategory->name = $parentData['name'];
                $parentCategory->image = $parentData['image'];
                $parentCategory->parent_id = $parentData['parent_id'];
                return $parentCategory;
            }
        }
        return null;
    }

    public function getMainCategories() {
        $query = "SELECT * FROM {$this->table} WHERE parent_id IS NULL";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubcategories($parent_id) {
        $query = "SELECT * FROM {$this->table} WHERE parent_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$parent_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProducts(): array {
        $query = "SELECT * FROM products WHERE category_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$this->id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProduct($product): void {
        $this->products[] = $product;
    }

    public function removeProduct(int $productId): void {
        $this->products = array_filter($this->products, function ($product) use ($productId) {
            return $product['id'] !== $productId;
        });
    }

    public function getProductById(int $productId): ?array {
        foreach ($this->products as $product) {
            if ($product['id'] === $productId) {
                return $product;
            }
        }
        return null;
    }

    public function addSubcategory(ICategory $category): void {
        $this->subcategories[] = $category;
    }

    public function removeSubcategory(int $categoryId): void {
        $this->subcategories = array_filter($this->subcategories, function ($category) use ($categoryId) {
            return $category->getId() !== $categoryId;
        });
    }

    public function getSubcategoryById(int $categoryId): ?ICategory {
        foreach ($this->subcategories as $category) {
            if ($category->getId() === $categoryId) {
                return $category;
            }
        }
        return null;
    }

    public function save(): bool {
        $query = "INSERT INTO {$this->table} (name, image, parent_id) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$this->name, $this->image, $this->parent_id]);
    }

    public function update(): bool {
        $query = "UPDATE {$this->table} SET name = ?, image = ?, parent_id = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$this->name, $this->image, $this->parent_id, $this->id]);
    }

    public function delete(): bool {
        $query = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$this->id]);
    }

    public function getCategoryById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteById($id): bool {
        $this->conn->beginTransaction();
        try {
            $this->conn->prepare("DELETE FROM products WHERE category_id = ?")->execute([$id]);
            $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?")->execute([$id]);
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return false;
        }
    }
}
