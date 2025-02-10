<?php

// Clase BookDTO: Clase que representa un objeto de transferencia de datos de Libro.
// Implementa la interfaz JsonSerializable para poder serializar el objeto a formato JSON.

// Importar las clases necesarias
require_once __DIR__ . '/../DAO/BookDAO.php';

class BookDTO implements JsonSerializable {

    // Atributos
    private $id;
    private $title;
    private $author;
    private $genre;

    private BookDAO $bookDAO;

    // Constructor con 4 atributos
    public function __construct($id = null, $title = null, $author = null, $genre = null) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->genre = $genre;
        $this->bookDAO = new BookDAO();  // El BookDTO se comunica con el DAO
    }

    // Obtener todos los libros
    public function getAllBooks(): array {
        return $this->bookDAO->getBooks();  // Se obtiene la lista de libros desde el DAO
    }

    // Obtener un libro por ID
    public function getBookById(int $id): ?BookDTO {
        return $this->bookDAO->getBookById($id);  // Se obtiene un solo libro por ID desde el DAO
    }   

    // Métodos Getter y Setter
    public function getId() {
        return $this->id;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title): void {
        $this->title = $title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor($author): void {
        $this->author = $author;
    }

    public function getGenre() {
        return $this->genre;
    }

    public function setGenre($genre): void {
        $this->genre = $genre;
    }

    // Implementación de JsonSerializable
    public function jsonSerialize(): mixed {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'genre' => $this->genre
        ];
    } 
}