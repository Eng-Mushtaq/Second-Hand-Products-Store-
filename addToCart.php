<?php
session_start();
// Include your database connection file
include 'db_connection.php'; // Change 'db_connection.php' to the actual name of your database connection script

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $user_id = $_SESSION['userid']; // Assuming you have a form field named user_id
    $product_id = $_POST['product_id']; // Assuming you have a form field named product_id
    $quantity = $_POST['quantity']; // Assuming you have a form field named quantity

    // Check if the user already has the product in the cart
    $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
    $existingProduct = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingProduct) {
        // If the product exists in the cart, update the quantity
        $newQuantity = $existingProduct['quantity'] + $quantity;
        $sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$newQuantity, $user_id, $product_id])) {
            header('location: cart.php');
        } else {
            echo "Error updating quantity in the cart table.";
        }
    } else {
        // If the product does not exist in the cart, insert a new row
        $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$user_id, $product_id, $quantity])) {
            header('location: cart.php');
        } else {
            echo "Error inserting data into the cart table.";
        }
    }
}
?>
