<?php

include('navbar.php');
// Include your database connection file
include 'db_connection.php';

// Fetch category data from the database
$stmt = $pdo->query("SELECT DISTINCT category.*
                     FROM category
                     INNER JOIN product ON category.category_id = product.category_id");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>توفير</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>



<div class="hero">
    <h1>موقع بيع الملابس والاثاث المستخدمة</h1>
    <p>مرحبًا بك في أفضل مكان لشراء وبيع الملابس والأثاث المستعملة عبر الإنترنت</p>
</div>
<?php foreach ($categories as $category): ?>
    <section id="<?php echo $category['name']; ?>" class="m-2">
        <div class="m-2">
            <div class="row rounded  border my-1">
                <div class="col-12">
                    <h2 class=""><?php echo $category['name']; ?></h2>
                </div>
            </div>
            <div class="row">
                <?php
                // Fetch product data filtered by category ID
                $stmt = $pdo->prepare("SELECT product.*, users.username, users.phone 
                                       FROM product 
                                       INNER JOIN users ON product.user_id = users.id 
                                       WHERE product.category_id = ?");
                $stmt->execute([$category['category_id']]); // Assuming category ID column is named 'id'
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 mb-4 mb-md-0">
                        <div class="item">
                            <a href="#"><img class="img" src="<?php echo $product['imagepath']; ?>" alt="<?php echo $product['imagepath']; ?>"></a>
                            <div class="content-entry">
                                <div class="row m-0 rounded border p-2">
                                    <h6 class="col-8"><?php echo $product['name']; ?></h6>
                                    <span class="col-4"><?php echo $product['price']; ?> ريال</span>
                                </div>
                                <div class="row m-0 my-2 rounded border p-2">
                                    <p><?php echo $product['description']; ?></p>
                                </div>
                                <div class="d-flex justify-content-evenly m-2">
									<a href="product_details.php?product_id=<?php echo $product['id']; ?>" class="btn btn-primary">
										<i class="fa fa-eye ms-1"></i> التفاصيل
									</a>
									<a href="shopping_cart.php?product_id=<?php echo $product['id']; ?>" class="btn btn-success">
										<i class="fas fa-shopping-cart"></i> اشتر الآن
									</a>
								</div>

                                <div class="w-100 p-2 border border-black mt-2 d-flex justify-content-between">
                                    <span><i class="fas fa-user text-primary"></i> <?php echo $product['username']; ?></span>
                                    <span><i class="fas fa-phone text-success"></i> <?php echo $product['phone']; ?></span>
                                    <span><i class="fas fa-calendar-alt text-info"></i> <?php echo $product['date']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endforeach; ?>

<div class="footer">
    <p>© 2024 Second Hand Store. All rights reserved.</p>
</div>

<!-- modal to add new product -->

<div class="modal fade modal-md" id="confirmationModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center bg-danger">
                        <h4 class="modal-title text-white fw-bold text-center" id="exampleModalLabel">إضافة منتج جديد</h4>
                    </div>
                    <form method="post" action="saveProduct.php" enctype="multipart/form-data">

                    <div class="modal-body ">
					<div class="form-group my-1">
                                <label for="productName">تصنيف المنتج:</label>
					<select class="form-select" name="category_id" required>
					<option selected disabled>اختر تصنيف المنتج</option>
					<?php
					$query = "SELECT * FROM category";
					$categories = $pdo->query($query);
					while ($category = $categories->fetch(PDO::FETCH_ASSOC)) {
						echo '<option value="'. $category["category_id"] . '">' . $category["name"] . '</option>';
					}
					?>
				</select>

                            </div>
                            <div class="form-group">
                                <label for="productName">اسم المنتج:</label>
                                <input type="text" class="form-control" name="productName" id="productName" placeholder="أدخل اسم المنتج" required> 
                            </div>
                            <div class="form-group">
                                <label for="description">وصف المنتج :</label>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="أدخل الوصف" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="imagePath">صورة المنتج :</label>
								<input type="file" accept="image/*" class="form-control" id="imagePath" name="imagePath" placeholder="قم باختيار صورة المنتج" required>
                            </div>
                            <div class="form-group">
                                <label for="price">السعر:</label>
                                <input type="number" class="form-control" id="price"v name="price" placeholder="أدخل السعر" required min="1">
                            </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إلغاء </button>
                        <button type="submit" name="submit" class="btn btn-success"> حفظ</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>
</body>
</html>
