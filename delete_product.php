<?php

require 'Database.php';

$db = new Database('localhost', 'product_list', 'root', '');

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $skus = $data['skus'];

    if (!empty($skus)) {
        $placeholders = implode(',', array_fill(0, count($skus), '?'));
        $types = str_repeat('s', count($skus));
        $stmt = $db->getConn()->prepare("DELETE FROM products WHERE sku IN ($placeholders)");
        $stmt->bind_param($types, ...$skus);
        if ($stmt->execute()) {
            $response['success'] = true;
        }
        $stmt->close();
    }
}

echo json_encode($response);

?>
