<?php

/**
 * Controlador para manejar las operaciones de los libros
 */

require_once __DIR__ . '/../models/DTO/BookDTO.php';

class BookController {

    private BookDTO $bookDTO;

    public function __construct() {
        $this->bookDTO = new BookDTO();
    }

    // Obtener todos los libros
    public function index(): void {
        try {
            $books = $this->bookDTO->getAllBooks();
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode($books, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            $this->handleError($e->getMessage(), 500);
        }
    }
    
    public function show(int $id): void {
        try {
            $book = $this->bookDTO->getBookById($id);
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