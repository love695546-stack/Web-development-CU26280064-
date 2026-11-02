<?php
// Q7: RESTful JSON API supporting GET, POST, PUT, DELETE
require_once __DIR__ . '/../models/Product.php';

class ProductController {
    private Product $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function index() {
        // Render view for traditional GET
        $products = $this->productModel->getAll();
        require_once __DIR__ . '/../views/products/index.php';
    }

    public function handleApi(string $method, ?int $id = null) {
        header('Content-Type: application/json');

        // Q8: Bearer Token Validation
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? '';
        if ($authHeader !== 'Bearer SECURE_SECRET_API_TOKEN_12345') {
            http_response_code(401);
            echo json_encode(["error" => "Unauthorized token"]);
            exit;
        }

        switch ($method) {
            case 'GET':
                if ($id) {
                    $data = $this->productModel->getById($id);
                    echo json_encode($data ?: ["error" => "Product not found"]);
                } else {
                    echo json_encode($this->productModel->getAll());
                }
                break;

            case 'POST':
                $input = json_decode(file_get_contents("php://input"), true);
                if (!empty($input['name']) && !empty($input['price'])) {
                    $this->productModel->create($input);
                    http_response_code(201);
                    echo json_encode(["message" => "Product created"]);
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "Invalid input"]);
                }
                break;

            case 'PUT':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(["error" => "ID required"]);
                    break;
                }
                $input = json_decode(file_get_contents("php://input"), true);
                $this->productModel->update($id, $input);
                echo json_encode(["message" => "Product updated"]);
                break;

            case 'DELETE':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(["error" => "ID required"]);
                    break;
                }
                $this->productModel->delete($id);
                echo json_encode(["message" => "Product deleted"]);
                break;

            default:
                http_response_code(405);
                echo json_encode(["error" => "Method not allowed"]);
                break;
        }
    }
}
