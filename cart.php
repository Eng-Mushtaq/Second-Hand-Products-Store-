<?php
include('navbar.php');
include 'db_connection.php'; // Include your database connection file

// Redirect to login page if user is not logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit;
}

// Get the user ID from the session
$user_id = $_SESSION['userid'];

// Retrieve products from the cart for the logged-in user
$stmt = $pdo->prepare("SELECT product.*, cart.quantity
                       FROM product
                       INNER JOIN cart ON product.id = cart.product_id
                       WHERE cart.user_id = ?");
$stmt->execute([$user_id]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<body>


<div class="container">
    <?php if (count($products) > 0): ?>
        <div class="card">
            <div class="card-header">
                <h2 class="text-center">المنتجات في السلة</h2>
            </div>

            <div class="row card-body p-0">
                <?php foreach ($products as $product): ?>
                    <div class="col-md-4">
                        <div class="card m-1">
                            <div class="card-header">
                                <h5 class="card-title"><?= $product['name'] ?></h5>
                            </div>
                            <div class="card-body p-1">
                                <img class="w-100 img" src="<?= $product['imagepath'] ?>">
                                <p class="card-text"><strong>الوصف:</strong> <?= $product['description'] ?></p>
                                <span class="card-text"><strong>السعر:</strong> <?= $product['price'] ?> ريال</span>
                                <span class="card-text mx-2 mx-lg-5"><strong>الكمية:</strong> <?= $product['quantity'] ?></span>
                                <p class="card-text"><strong>الإجمالي:</strong> <?= $product['price'] * $product['quantity'] ?> ريال</p>
                            </div>
                            <div class="card-footer d-flex justify-content-center">
                                <a href="shopping_cart.php?product_id=<?= $product['id'] ?>" class="btn btn-primary mx-2">تعديل</a>
                                <a href="deleteFromCart.php?product_id=<?= $product['id'] ?>" class="btn btn-danger">حذف</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="card-footer d-flex justify-content-center my-2">
                <a href="payment.php" class="btn btn-success"><i class="fas fa-money"></i> تأكيد الشراء</a>
            </div>
        </div>
    <?php else: ?>
        <h3 class="text-center">سلة التسوق فارغة</h3>
    <?php endif; ?>
</div>
    </body>
</html>
