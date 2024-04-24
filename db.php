<?php
$sql = "create database if not exists simple_cart";
$conn = mysqli_connect("localhost","root","");
$conn->query($sql);
// echo "database created";
$sql = "create table if not exists product(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL
    )";
$conn = mysqli_connect("localhost","root","","simple_cart");
$conn->query($sql);
// echo "table created";
$query = "SELECT COUNT(*) as count FROM product";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$productCount = $row['count'];

if ($productCount == 0) {
    // Products don't exist, so insert them
    $sql ="INSERT INTO product (name, price)
            VALUES 
            ('Product 1', 10.00),
            ('Product 2', 15.00),
            ('Product 3', 20.00)";
    $conn->query($sql);
} 

?>