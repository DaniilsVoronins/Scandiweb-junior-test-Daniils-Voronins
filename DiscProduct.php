<?php
class DiscProduct extends Product{
    private $size;

    public function __construct($sku, $name, $price, $size){
        parent::__construct($sku, $name, $price);
        $this->size = $size;
    }
    public function save($conn){
        $stmt = $conn->prepare("INSTER INTO products(sku, name, price, size, type) VALUES (?, ?, ?, ?, 'disc')");
        $stmt->bind_param("ssds",$this->sku, $this->name, $this->price, $this->size);
        $stmt->execute();
        $stmt->close();
    }
}
?>