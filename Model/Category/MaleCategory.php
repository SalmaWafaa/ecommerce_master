<?php


require_once 'C:\xampp\htdocs\ecommerce_master\Model\Category\CategoryComposite.php';
class MaleCategory extends CategoryComposite {
    public function __construct(int $id, string $name, string $image, ?ICategory $parentCategory = null) {
        parent::__construct($id, $name, $image, $parentCategory);
    }
}