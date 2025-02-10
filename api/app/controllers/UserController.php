<?php

/**
 * Controlador para manejar las operaciones de los usuarios
 */

 require_once __DIR__ . '/../models/DTO/UserDTO.php';;

class UserController {

    private UserDTO $userDTO;

    public function __construct() {
        $this->userDTO = new UserDTO();
    }

    // Metodo para mostrar todos los usuarios
    public function index(): void {
        try {
            $users = $this->userDTO->getUsers(); // Obtiene un array de UserDTO
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); // Los UserDTO implementan JsonSerializable
        } catch(Exception $e) {
            $this->handleError($e->getMessage(), 500);
        }
    }      

     // Método para obtener un usuario por su ID
    public function show(int $id): void {
        try {
            $book = $this->userDTO->getUserById($id);
            if (!$book) {
                $this->handleError("Libro no encontrado.", 404);
                return;
            }
    
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode($book, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            $this->handleError($e->getMessage(), 500);
        }
    }

    // Manejar errores
    private function handleError(string $message, int $code): void {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode(['error' => $message], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}