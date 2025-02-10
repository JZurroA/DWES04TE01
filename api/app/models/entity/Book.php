<?php

/**
 * Clase Book: Modelo para manejar los libros
 */

 class Book {
    // Atributos
    protected $id;
    protected $title;
    protected $author;
    protected $genre;

    // Constructor
    public function __construct(int $id = null, string $title = null, string $author = null, string $genre = null) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->genre = $genre;
    }

    // Getters and Setters

    /**
     * Get the value of id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Get the value of title
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set the value of title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Get the value of title
     */
    public function getGenre() {
        return $this->genre;
    }

    /**
     * Set the value of title
     */
    public function setGenre($genre) {
        $this->genre = $genre;
    }

    /**
     * Get the value of author
     */
    public function getAuthor() {
        return $this->author;
    }   

    /**
     * Set the value of author
     */
    public function setAuthor($author) {
        $this->author = $author;
    }

    // Metodo para convertir el objeto a un array
    public function toArray() {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'genre' => $this->genre
        ];
    }   
}