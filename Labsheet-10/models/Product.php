<?php
// Q5: Model class with reusable CRUD methods
require_once __DIR__ . '/../config/database.php';

class Product {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM products");
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch();
        return $product ?: null;
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare("INSERT INTO products (name, category, price) VALUES (:name, :category, :price)");
        return $stmt->execute([
            'name' => $data['name'],
            'category' => $data['category'],
            'price' => $data['price']
        ]);
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare("UPDATE products SET name = :name, category = :category, price = :price WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'category' => $data['category'],
            'price' => $data['price']
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
