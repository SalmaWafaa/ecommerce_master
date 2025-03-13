<?php

//namespace Controllers;

require_once 'C:\xampp\htdocs\ecommerce_master\Model\Category\CategoryComposite.php';
require_once 'C:\xampp\htdocs\ecommerce_master\Model\Category\MaleCategory.php';
require_once 'C:\xampp\htdocs\ecommerce_master\Model\Category\FemaleCategory.php';
require_once 'C:\xampp\htdocs\ecommerce_master\Model\Category\MaleTshirtCategory.php';
require_once 'C:\xampp\htdocs\ecommerce_master\Model\Category\MalePantsCategory.php';
require_once 'C:\xampp\htdocs\ecommerce_master\Model\Category\FemaleSkirtCategory.php';
require_once 'C:\xampp\htdocs\ecommerce_master\Model\Products\BasicTshirt.php';
require_once 'C:\xampp\htdocs\ecommerce_master\Model\Products\ShortSleeveTshirt.php';
require_once 'C:\xampp\htdocs\ecommerce_master\Model\Products\LongSleeveTshirt.php';
require_once 'C:\xampp\htdocs\ecommerce_master\Model\Products\BasicPant.php';
require_once 'C:\xampp\htdocs\ecommerce_master\Model\Products\BasicSkirt.php';
// class CategoryController {
//     public function listCategories() {
//         // Create sample categories
//         $maleCategory = new MaleCategory(1, "Male", "male.jpg");
//         $femaleCategory = new FemaleCategory(2, "Female", "female.jpg");

//         $maleTshirtCategory = new MaleTshirtCategory(3, "Male Tshirts", "male_tshirts.jpg", $maleCategory);
//         $malePantsCategory = new MalePantsCategory(4, "Male Pants", "male_pants.jpg", $maleCategory);
//         $femaleSkirtCategory = new FemaleSkirtCategory(5, "Female Skirts", "female_skirts.jpg", $femaleCategory);

//         // Add subcategories to main categories
//         $maleCategory->addSubcategory($maleTshirtCategory);
//         $maleCategory->addSubcategory($malePantsCategory);
//         $femaleCategory->addSubcategory($femaleSkirtCategory);

//         // Create sample products
//         $basicTshirt = new BasicTshirt(
//             1,
//             "Basic Tshirt",
//             ["Red", "Blue"],
//             ["S", "M"],
//             ["img1.jpg"],
//             4.5,
//             [],
//             100,
//             10,
//             29.99
//         );

//         $shortSleeveTshirt = new ShortSleeveTshirt(
//             2,
//             "Short Sleeve Tshirt",
//             ["Green", "Yellow"],
//             ["M", "L"],
//             ["img2.jpg"],
//             4.7,
//             [],
//             50,
//             5,
//             19.99
//         );

//         $longSleeveTshirt = new LongSleeveTshirt(
//             3,
//             "Long Sleeve Tshirt",
//             ["Black", "White"],
//             ["L", "XL"],
//             ["img3.jpg"],
//             4.8,
//             [],
//             75,
//             15,
//             39.99
//         );

//         $basicPant = new BasicPant(
//             4,
//             "Basic Pant",
//             ["Black", "Gray"],
//             ["32", "34"],
//             ["img4.jpg"],
//             4.6,
//             [],
//             60,
//             10,
//             59.99
//         );

//         $basicSkirt = new BasicSkirt(
//             5,
//             "Basic Skirt",
//             ["Pink", "Purple"],
//             ["S", "M"],
//             ["img5.jpg"],
//             4.9,
//             [],
//             40,
//             5,
//             49.99
//         );

//         // Add products to categories
//         $maleTshirtCategory->addProduct($basicTshirt);
//         $maleTshirtCategory->addProduct($shortSleeveTshirt);
//         $maleTshirtCategory->addProduct($longSleeveTshirt);
//         $malePantsCategory->addProduct($basicPant);
//         $femaleSkirtCategory->addProduct($basicSkirt);

//         // Pass data to the view
//         $categories = [$maleCategory, $femaleCategory];
//         include 'C:\xampp\htdocs\ecommerce_master\View\category_list.php';
//     }

//     public function showCategoryDetails($categoryId) {
//         // Fetch category details (for demonstration, we use a hardcoded category)
//         $maleCategory = new MaleCategory(1, "Male", "male.jpg");
//         $maleTshirtCategory = new MaleTshirtCategory(3, "Male Tshirts", "male_tshirts.jpg", $maleCategory);

//         // Add sample products to the category
//         $basicTshirt = new BasicTshirt(
//             1,
//             "Basic Tshirt",
//             ["Red", "Blue"],
//             ["S", "M"],
//             ["img1.jpg"],
//             4.5,
//             [],
//             100,
//             10,
//             29.99
//         );

//         $maleTshirtCategory->addProduct($basicTshirt);

//         // Pass data to the view
//         $category = $maleTshirtCategory;
//         include 'C:\xampp\htdocs\ecommerce_master\View\category_details.php';
//     }
// }
class CategoryController {
    public function listMainCategories() {
        // Pass data to the view
        include 'C:\xampp\htdocs\ecommerce_master\View\category_list.php';
    }

    public function listMaleCategories() {
        // Create male categories
        $maleCategory = new MaleCategory(1, "Male", "male.jpg");

        $maleTshirtCategory = new MaleTshirtCategory(2, "Male Tshirts", "male_tshirts.jpg", $maleCategory);
        $malePantsCategory = new MalePantsCategory(3, "Male Pants", "male_pants.jpg", $maleCategory);

        // Add subcategories to male category
        $maleCategory->addSubcategory($maleTshirtCategory);
        $maleCategory->addSubcategory($malePantsCategory);

        // Pass data to the view
        $categories = [$maleTshirtCategory, $malePantsCategory];
        include 'C:\xampp\htdocs\ecommerce_master\View\category_details.php';
    }

    public function listFemaleCategories() {
        // Create female categories
        $femaleCategory = new FemaleCategory(4, "Female", "female.jpg");

        $femaleSkirtCategory = new FemaleSkirtCategory(5, "Female Skirts", "female_skirts.jpg", $femaleCategory);

        // Add subcategories to female category
        $femaleCategory->addSubcategory($femaleSkirtCategory);

        // Pass data to the view
        $categories = [$femaleSkirtCategory];
        include 'C:\xampp\htdocs\ecommerce_master\View\category_details.php';
    }

    public function listProducts($categoryId) {
        // Fetch products for the given category (for demonstration, we use hardcoded products)
        $products = [];

        switch ($categoryId) {
            case 2: // Male Tshirts
                $products = [
                    new BasicTshirt(1, "Basic Tshirt", ["Red", "Blue"], ["S", "M"], ["img1.jpg"], 4.5, [], 100, 10, 29.99),
                    new ShortSleeveTshirt(2, "Short Sleeve Tshirt", ["Green", "Yellow"], ["M", "L"], ["img2.jpg"], 4.7, [], 50, 5, 19.99),
                ];
                break;
            case 3: // Male Pants
                $products = [
                    new BasicPant(3, "Basic Pant", ["Black", "Gray"], ["32", "34"], ["img3.jpg"], 4.6, [], 60, 10, 59.99),
                ];
                break;
            case 5: // Female Skirts
                $products = [
                    new BasicSkirt(4, "Basic Skirt", ["Pink", "Purple"], ["S", "M"], ["img4.jpg"], 4.9, [], 40, 5, 49.99),
                ];
                break;
        }

        // Pass data to the view
        include  'C:\xampp\htdocs\ecommerce_master\View\product_list.php';
    }
}