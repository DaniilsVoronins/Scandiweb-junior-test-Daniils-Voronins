<?php
class FurnitureProduct extends Product {
    private $dimensions;

    public function __construct($sku, $name, $price, $dimensions) {
        parent::__construct($sku, $name, $price);
        $this->dimensions = $dimensions;
    }

    public function save($conn) {
        $stmt = $conn->prepare("INSERT INTO products (sku, name, price, dimension, type) VALUES (?, ?, ?, ?, 'furniture')");
        $stmt->bind_param("ssds", $this->sku, $this->name, $this->price, $this->dimensions);
        $stmt->execute();
        $stmt->close();
    }
}


?>
