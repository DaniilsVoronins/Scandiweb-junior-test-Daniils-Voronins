<?php
class BookProduct extends Product {
    private $weight;

    public function __construct($sku, $name, $price, $weight) {
        parent::__construct($sku, $name, $price);
        $this->weight = $weight;
    }
    public function save($conn) {
        $stmt = $conn->prepare("INSERT INTO products (sku, name, price, weight, type) VALUES (?, ?, ?, ?, 'book')");
        $stmt->bind_param("ssds", $this->sku, $this->name, $this->price, $this->weight);
        $stmt->execute();
        $stmt->close();
    }
}
?>