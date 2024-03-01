<?php
session_start();
$user_id = $_SESSION['userid'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include 'db_connection.php'; // Change 'db_connection.php' to the actual name of your database connection script

    // Define variables and initialize with empty values
    $productName = $description = $imagePath = $price = "";
    $productName = $_POST['productName'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
   // Assuming user_id is hardcoded for this example
    $currentDate = date("Y-m-d");

    // Check if file was uploaded without errors
    if(isset($_FILES["imagePath"]) && $_FILES["imagePath"]["error"] == 0){
        $imagePath = "images/uploads/" . basename($_FILES["imagePath"]["name"]);
        if(move_uploaded_file($_FILES["imagePath"]["tmp_name"], $imagePath)){
            // File uploaded successfully
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "No file uploaded.";
    }

    // Prepare an insert statement
    $sql = "INSERT INTO product (category_id,name, description, imagePath, price,date ,user_id) VALUES (?,?, ?, ?, ?, ?,?)";

    if ($stmt = $pdo->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(1, $category_id);
        $stmt->bindParam(2, $productName);
        $stmt->bindParam(3, $description);
        $stmt->bindParam(4, $imagePath);
        $stmt->bindParam(5, $price);
        $stmt->bindParam(6, $currentDate);
        $stmt->bindParam(7, $user_id);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            header('location:index.php');


        } else {
            echo "Error saving product.";
        }

        // Close statement
    }

    // Close connection
    $pdo = null;
}
?>
