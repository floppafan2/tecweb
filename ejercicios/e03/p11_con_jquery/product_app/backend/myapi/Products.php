<?php

require_once "DataBase.php";

class Products extends DataBase {
    private $response = [];
    
    public function __construct($db, $user, $pass) {
        parent::__construct($db, $user, $pass);
    }
    
    public function add($object) {
        $name = $object["name"];
        $price = $object["price"];
        $query = "INSERT INTO products (name, price) VALUES ('$name', '$price')";
        $this->conexion->query($query);
    }
    
    public function delete($id) {
        $query = "DELETE FROM products WHERE id = '$id'";
        $this->conexion->query($query);
    }
    
    public function edit($object) {
        $id = $object["id"];
        $name = $object["name"];
        $price = $object["price"];
        $query = "UPDATE products SET name = '$name', price = '$price' WHERE id = '$id'";
        $this->conexion->query($query);
    }
    
    public function list() {
        $query = "SELECT * FROM products";
        $result = $this->conexion->query($query);
        $this->response = $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function search($term) {
        $query = "SELECT * FROM products WHERE name LIKE '%$term%'";
        $result = $this->conexion->query($query);
        $this->response = $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function single($id) {
        $query = "SELECT * FROM products WHERE id = '$id'";
        $result = $this->conexion->query($query);
        $this->response = $result->fetch_assoc();
    }
    
    public function singleByName($name) {
        $query = "SELECT * FROM products WHERE name = '$name'";
        $result = $this->conexion->query($query);
        $this->response = $result->fetch_assoc();
    }
    
    public function getData() {
        return json_encode($this->response);
    }
}

?>
