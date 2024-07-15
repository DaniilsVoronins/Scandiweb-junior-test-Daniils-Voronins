<?php
require 'Database.php';
require 'Product.php';
require 'DiscProduct.php';
require 'BookProduct.php';
require 'FurnitureProduct.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Database('localhost', 'product_list', 'root', '');

    $sku = $_POST['sku'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $type = $_POST['productType'];

    // Check if SKU is unique
    $stmt = $db->getConn()->prepare("SELECT COUNT(*) FROM products WHERE sku = ?");
    $stmt->bind_param("s", $sku);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        $response['message'] = 'SKU already exists';
        echo json_encode($response);
        exit;
    }

    switch ($type) {
        case 'DVD':
            $size = $_POST['size'];
            $product = new DiscProduct($sku, $name, $price, $size);
            break;
        case 'Book':
            $weight = $_POST['weight'];
            $product = new BookProduct($sku, $name, $price, $weight);
            break;
        case 'Furniture':
            $dimensions = $_POST['height'] . 'x' . $_POST['width'] . 'x' . $_POST['length'];
            $product = new FurnitureProduct($sku, $name, $price, $dimensions);
            break;
        default:
            $response['message'] = 'Invalid product type';
            echo json_encode($response);
            exit;
    }

    $product->save($db->getConn());
    $response['success'] = true;
    echo json_encode($response);
}

?>
