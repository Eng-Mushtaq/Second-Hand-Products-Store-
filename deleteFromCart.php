<?php
session_start();
// Include your database connection file
include 'db_connection.php'; // Change 'db_connection.php' to the actual name of your database connection script
if (isset($_GET['product_id'])) {
    // Get the product_id from the URL
    $product_id = $_GET['product_id'];
        $user_id = $_SESSION['userid'];
        $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $pdo->prepare($sql);
    
    // Attempt to execute the SQL statement
    if ($stmt->execute([$user_id, $product_id])) {
        // Product successfully deleted from the cart
        header('Location: cart.php');
        exit(); // Stop further execution of the script
    } else {
        // Error deleting product from the cart
        echo "Error deleting product from the cart.";
    }
} else {
    // Redirect to the cart page if product_id is not set in the URL
    header('Location: cart.php');
    exit(); // Stop further execution of the script
}
?>
