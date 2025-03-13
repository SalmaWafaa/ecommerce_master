<!DOCTYPE html>
<html>
<head>
    <title>Main Categories</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .category { margin-bottom: 20px; padding: 10px; border: 1px solid #ccc; }
        .category h2 { margin: 0; }
        .category button { margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Main Categories</h1>

    <div class="category">
        <h2>Male</h2>
        <button onclick="window.location.href='index.php?controller=Category&action=listMaleCategories'">
            View Male Categories
        </button>
    </div>

    <div class="category">
        <h2>Female</h2>
        <button onclick="window.location.href='index.php?controller=Category&action=listFemaleCategories'">
            View Female Categories
        </button>
    </div>
</body>
</html>