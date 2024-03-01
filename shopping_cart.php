<?php
include('navbar.php');
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>توفير</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .vertical {
            border-left: 6px solid rgb(38, 33, 33);
            height:80%;
            position: absolute;
            right: 50%;
            border-radius: 3px;
            background-color: rgb(38, 33, 33);
            max-height: 500px;

        }
        .horizontal{
            border-top: 6px solid rgb(38, 33, 33);
            width:99%;
            position: absolute;
            right: 0;
            border-radius: 3px;
            background-color: rgb(38, 33, 33);
            max-width: 500px;
            margin-bottom: 10px;
            
        }
        .details-img{
            max-height: 500px;
        }
    </style>
</head>
<body>

    <div class="container">
        <?php
        // Include your database connection file
        include 'db_connection.php'; // Change 'db_connection.php' to the actual name of your database connection script

        // Check if product ID is provided in the URL
        if(isset($_GET['product_id'])) {
            // Retrieve the product details from the database based on the provided ID
            $product_id = $_GET['product_id'];
            $stmt = $pdo->prepare("SELECT * FROM product WHERE id = ?");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if($product) {
                // Product details found, display them
                ?>
                <div class="card card-shadow">
<div class="card-header">
<h1 class="text-center my-2">إضافة إلى السلة</h1>

                </div>
<div class="row p-2 card-body">

<div class="col-md-6">
    <div class="vertical d-none d-md-block mx-1"></div>
        <img class="w-100 details-img" src="<?php echo $product['imagepath']; ?>" alt="<?php echo $product['name']; ?>">
        <div class="horizontal d-block d-md-none mx-1"></div>

    </div>


    <div class="col-md-6 mt-2 m-md-0">
    <form class="w-100 d-flex align-items-center flex-column" method="post" action="addToCart.php">
    <h2><?php echo $product['name']; ?></h2>
    <p><strong>الوصف:</strong> <?php echo $product['description']; ?></p>
    <p><strong>السعر:</strong> <span id="price"><?php echo $product['price']; ?> </span>ريال</p>
    <p><strong>الإجمالي:</strong> <span id="totalprice"><?php echo $product['price']; ?> </span>ريال</p>
    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

    <div class="input-group my-3">
        <div class="input-group-prepend">
            <button class="btn btn-danger" type="button" id="minus">-</button>
        </div>
        <input type="number" name="quantity" class="form-control" value="1" min="1" id="quantity" required>
        <div class="input-group-append">
            <button class="btn btn-success" type="button" id="plus">+</button>
        </div>
    </div>
    <button type="submit" class="btn btn-success"> <i class="fas fa-shopping-cart"></i> إضافة إلى السلة</button>
</form>
    </div>
   
  
</div>

</div>
                <?php
            } else {
                // Product not found
                echo "<p>المنتج غير موجود</p>";
            }
        } else {
            // Product ID not provided in the URL
            echo "<p>رقم المنتج غير محدد</p>";
        }
        ?>
    </div>
</body>
<script>
    var totalPriceInput = document.getElementById('totalprice');
    var price = <?php echo $product['price']; ?>;
    var quantityInput = document.getElementById('quantity');
    var plusButton = document.getElementById('plus');
    var minusButton = document.getElementById('minus');

    plusButton.addEventListener('click', function() {
        calculate(1);
    });

    minusButton.addEventListener('click', function() {
        calculate(-1);
    });

    function calculate(change) {
        var quantity = parseInt(quantityInput.value);
        quantity += change;
        if (quantity < 1) {
            quantity = 1; // Ensure quantity doesn't go below 1
        }
        quantityInput.value = quantity;
        totalPriceInput.textContent = price * quantity; // Update total price
    }
</script>


</html>
