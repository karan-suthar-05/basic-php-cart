<?php
session_start();
include_once "db.php";

if (isset( $_POST['product_id'] , $_POST['add_to_cart'] )) 
{
    $product_id = $_POST['product_id'];
    $quantity = isset( $_POST['quantity'] ) ? intval($_POST['quantity']) : 1; 
    $product_exists = false;
    foreach ( $_SESSION['cart'] as $key => $item) {
        if ( $item['id'] == $product_id )
         {
            
            $_SESSION['cart'][$key]['quantity'] += $quantity;
            $product_exists = true;
            break;
        }
    }

    if (!$product_exists) 
    {
        
        $query = "select * from product where id = $product_id";
        $result = $conn->query($query);

        if ($result) 
        {
            $product = $result->fetch_assoc();

            if (!empty($product)) 
            {
                $_SESSION['cart'][] = array(
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $quantity
                );
            }
             else {
                echo "Product not found.";
            }
        } 
        else {
            echo "Error fetching product details: " . $conn->error;
        }
    }

    header("Location: cart.php");
    exit();
}

$query = "select * from product";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Product</title>
</head>

<body>
    <h2>Products</h2>
    <ul style="display:flex;list-style:none;">
        <?php while ($row = $result->fetch_assoc()) : ?>
            <li style="padding:5vw;">
                <?php echo $row['name']; ?> : Rs.<?php echo $row['price']; ?>
                <form action="product.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    Quantity: <input type="number" name="quantity" value="1" min="1">
                    <input type="submit" name="add_to_cart" value="Add to Cart">
                </form>
            </li>
        <?php endwhile; ?>
    </ul>

</body>

</html>
