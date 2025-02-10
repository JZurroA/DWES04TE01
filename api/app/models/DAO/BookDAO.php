<?php

// Clase BookDAO: Clase para manejar la capa de acceso a datos de libros

// Importar las clases necesarias
require_once __DIR__ . '/../../../core/DataBase.php';
require_once __DIR__ . '/../DTO/BookDTO.php';

class BookDAO {
    // Propiedad para almacenar la conexión a la base de datos
    private PDO $connection;

    // Constructor. Desde aquí se instancia la conexión a la base de datos
    public function __construct() {
        $this->connection = DataBase::getInstance()->getConnection();
    }

    // Obtener todos los libros
    public function getBooks(): array {
        try {
            $query = "SELECT * FROM books";
            $statement = $this->connection->query($query);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            return array_map([$this, 'mapToDTO'], $result);
        } catch(PDOException $e) {
            throw new Exception("Error fetching books: " . $e->getMessage());
        }
    }

    // Obtener un libro por ID
    public function getBookById(int $id): ?BookDTO {
        try {
            $query = "SELECT * FROM books WHERE id = :id";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            return $result ? $this->mapToDTO($result) : null;
        } catch(PDOException $e) {
            throw new Exception("Error fetching book by ID: " . $e->getMessage());
        }
    }

    // Método para mapear los datos de la base de datos a un objeto DTO
    private function mapToDTO(array $row): BookDTO {
        if(!isset($row['id'], $row['title'], $row['author'], $row['genre'])) {
            throw new Exception("Invalid data format for BookDTO");
        }
        
        return new BookDTO(
            $row['id'],
            $row['title'],
            $row['author'],
            $row['genre']
        );
    }
}