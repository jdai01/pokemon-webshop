<?php
// Start the session to access session variables
session_start();

// File Paths
$username = $_SESSION['username'];
$productFile = 'json/product.json';
$defaultShoppingFile = 'users/shoppingCart.json';
// $username = $_SESSION['username'] ?? null;
// $shoppingFile = $username ? "users/$username/shoppingCart.json" : $defaultShoppingFile;
// $orderHistoryFile = $username ? "users/$username/orderHistory.json" : null;


// Load Products
$products = json_decode(file_get_contents($productFile), true)['product'];
$productMap = array_column($products, null, 'pid');




// == Shopping Cart ==

// Check if the user is logged in
if (isset($username)) {
    $shoppingFile = 'users/' . $username . '/shoppingCart.json';
    $orderHistoryFile = "users/" . $username . "/orderHistory.json";
} else { 
    $shoppingFile = $defaultShoppingFile;
}

// Read the shopping cart data from the JSON file
if (file_exists($shoppingFile)) {
    $fileData = json_decode(file_get_contents($shoppingFile), true);
    $cart = isset($fileData['cart']) ? $fileData['cart'] : [];
} else {
    $cart = [];
}


// == Price Save in JSON ==
global $totalPrice, $discount, $shipping;

// Initialize the variables
$totalPrice = 0;
$discount = 1;
$shipping = 4.99;

// Calculate totals
foreach ($cart as $item) {
    $product = $productMap[$item['pid']];
    $totalPrice += $product['price'] * $item['qty'];
}

// Perform calculations
$tax = round($totalPrice * 0.19, 2);
$totalPriceWOtax = round($totalPrice - $tax, 2);
$totalPrice = round($totalPrice, 2);
$finalPrice = $totalPrice - $discount + $shipping;

// Handle the AJAX request
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['action'])) {
    $action = $input['action'];

    if ($action === 'update' && isset($input['pid'], $input['qty'])) {
        $pid = $input['pid'];
        $qty = (int)$input['qty'];

        foreach ($cart as &$item) {
            if ($item['pid'] == $pid) {
                $item['qty'] = $qty;
                break;
            } 
        }

        file_put_contents($shoppingFile, json_encode(['cart' => $cart], JSON_PRETTY_PRINT));

        // Calculate the updated total price
        $totalPrice = 0;
        foreach ($cart as $item) {
            $product = $productMap[$item['pid']];
            $totalPrice += $product['price'] * $item['qty'];
        }

        echo json_encode(['success' => true, 'totalPrice' => round($totalPrice, 2)]);
    } elseif ($action === 'remove' && isset($input['pid'])) {
        $pid = $input['pid'];
        $cart = array_filter($cart, function ($item) use ($pid) {
            return $item['pid'] !== $pid;
        });

        file_put_contents($shoppingFile, json_encode(['cart' => array_values($cart)], JSON_PRETTY_PRINT));

        $totalPrice = 0;
        foreach ($cart as $item) {
            $product = $productMap[$item['pid']];
            $totalPrice += $product['price'] * $item['qty'];
        }

        echo json_encode(['success' => true, 'totalPrice' => round($totalPrice, 2)]);
    } elseif ($action === 'proceed_to_payment') {
        if (!isset($_SESSION['username'])) {
            echo json_encode(['success' => false, 'error' => 'User not logged in.']);
            exit;
        }
    
        // User-specific file paths
        $username = $_SESSION['username'];
        $userCartFile = "users/$username/shoppingCart.json";
        $orderHistoryFile = "users/$username/orderHistory.json";
    
        // Check if shopping cart exists
        if (!file_exists($userCartFile)) {
            echo json_encode(['success' => false, 'error' => 'Shopping cart not found.']);
            exit;
        }
    
        // Read and update cart data
        $cartData = json_decode(file_get_contents($userCartFile), true);
        $cartData['status'] = 'processing';
        $cartData['shipping'] = $shipping;
        $cartData['discount'] = $discount;
        $cartData['totalPrice'] = $totalPrice;
        $cartData['orderID'] = $username . '-' . bin2hex(random_bytes(5)); // 10 alphanumeric characters
        $cartData['datetime'] = date('Y-m-d H:i:s');
        
        // Append order to order history
        $orderHistory = file_exists($orderHistoryFile) 
            ? json_decode(file_get_contents($orderHistoryFile), true) 
            : [];
        $orderHistory[] = $cartData;
        file_put_contents($orderHistoryFile, json_encode($orderHistory, JSON_PRETTY_PRINT));
    
        // Clear shopping cart
        file_put_contents($userCartFile, json_encode(['cart' => []], JSON_PRETTY_PRINT));
    
        echo json_encode(['success' => true, 'message' => 'Order placed successfully!']);
        // exit;
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid action or parameters.']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/darkmode.css">
    <link rel="stylesheet" href="styles/buttons.css">
    <link rel="stylesheet" href="styles/shoppingCart.css">
    <script src="script/shoppingCart.js"></script>
</head>

<body>
    <!-- Header -->
    <header>
        <?php include("header.php"); ?>
    </header>

    <!-- Main -->
    <main>
        <a href="all-products.php">To Products Display</a>
        <?php if (empty($cart)): ?>
        <h1>Empty shopping cart :(</h1>
        <img src="https://media.printables.com/media/prints/599251/images/4771188_2e14b654-daa7-478c-8cc8-f5db25dce657_75ec0dd6-e0f7-4d1a-9c56-8a31dd407287/suprised-pikachu.png"
            alt="Pikachu" width="300px">
        <?php else: ?>
        <h1>Your Shopping Cart</h1>
        <div class="container">
            <div class="container product-container">
                <?php 
                foreach ($cart as $item) {
                    $pid = $item['pid'];
                    if (isset($productMap[$pid])) {
                        $product = $productMap[$pid];
                        $name = $product['name'];
                        $img = $product['img_src'];
                        $price = $product['price'];
                        $qty = $item['qty'];

                        echo "<div class='box' id='product-" . htmlspecialchars($pid) . "'>";
                        echo "<img src='" . htmlspecialchars($img) . "' class='pImg' alt='" . htmlspecialchars($name) . "'>";
                        echo "<div class='left'>";
                        echo "<span class='pid'>#" . htmlspecialchars($pid) . "</span>";
                        echo "<span class='pName'>" . htmlspecialchars($name) . "</span>";
                        echo "</div>";
                        echo "<div class='right'>";
                        echo "<span class='price'>" . number_format(htmlspecialchars($price), 2) . "€ </span>";
                        echo "<input type='number' value='" . htmlspecialchars($qty) . "' name='qty[" . htmlspecialchars($pid) . "]' id='qty-" . htmlspecialchars($pid) . "' min='1' onchange='updateCartQty(\"" . htmlspecialchars($pid) . "\", this.value)' />";
                        echo "<button class='btn-red delete' id='delete-" . htmlspecialchars($pid) . "' onclick='removeFromCart(\"" . htmlspecialchars($pid) . "\")'>Remove</button>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
                ?>
            </div>

            <div class="container summary-container">
                <div class="container price-container">
                    Order Summary
                    <?php
                    // $totalPrice = 0;
                    // foreach ($cart as $item) {
                    //     $product = $productMap[$item['pid']];
                    //     $totalPrice += $product['price'] * $item['qty'];
                    // }

                    // $tax = round($totalPrice * 0.19, 2);
                    // $totalPriceWOtax = round($totalPrice - $tax, 2);
                    // $totalPrice = round($totalPrice, 2);
                    // $discount = 0;
                    // $shipping = 4.99;
                    // $finalPrice = $totalPrice - $discount + $shipping;
                    ?>

                    <div class="container">
                        <div class="left"><strong>Total Price (without tax)</strong></div>
                        <div class="right"><?php echo number_format($totalPriceWOtax, 2); ?>€</div>
                    </div>
                    <div class="container">
                        <div class="left"><strong>Tax (19%)</strong></div>
                        <div class="right"><?php echo number_format($tax, 2); ?>€</div>
                    </div>
                    <hr>
                    <div class="container">
                        <div class="left"><strong>Subtotal</strong></div>
                        <div class="right"><?php echo number_format($totalPrice, 2); ?>€</div>
                    </div>
                    <?php if ($discount != 0): ?>
                    <div class="container">
                        <div class="left"><strong>Discount</strong></div>
                        <div class="right"><?php echo "- " . number_format($discount, 2); ?>€</div>
                    </div>
                    <?php endif; ?>
                    <div class="container">
                        <div class="left"><strong>Shipping</strong></div>
                        <div class="right"><?php echo number_format($shipping, 2); ?>€</div>
                    </div>
                    <hr>
                    <div class="container">
                        <div class="left"><strong>Total</strong></div>
                        <div class="right subtotal"><span><?php echo number_format($finalPrice, 2); ?>€</span></div>
                    </div>
                    <button class="btn-blue payment" id="paymentBtn">Proceed to Payment</button>
                </div>

                <div class="container discount-container">
                    Enter Discount Code
                    <input type="text">
                    <button>Redeem Voucher</button>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>
<!-- <script>
document.getElementById('paymentBtn').addEventListener('click', function() {
    // Prepare the order data
    const orderData = {
        action: 'createOrder',
        cart: <?php //echo json_encode($cart); ?>,
discount: <?php //echo $discount; ?>,
username: '<?php //echo $_SESSION['username']; ?>',
datetime: new Date().toISOString()
};

// Send the order data to the server via AJAX
fetch('shoppingCart.php', {
method: 'POST',
headers: {
'Content-Type': 'application/json'
},
body: JSON.stringify(orderData)
})
.then(response => response.json())
.then(data => {
if (data.success) {
alert('Order created successfully!');
window.location.href = "orderHistory.php"; // Redirect to confirmation page
} else {
alert('Error creating order.');
}
})
.catch(error => console.error('Error:', error));
});
</script> -->

</html>