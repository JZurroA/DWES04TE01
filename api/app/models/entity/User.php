<?php

class User {
    private $id;
    private $name;
    private $surname;
    private $email;

    // Constructor
    public function __construct($id, $name, $surname, $email) {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
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
     * Get the value of name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Get the value of surname
     */
    public function getSurname() {
        return $this->surname;
    }

    /**
     * Set the value of surname
     */
    public function setSurname($surname) {
        $this->surname = $surname;
    }

    /**
     * Get the value of email
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    // Metodo para convertir el objeto a un array
    public function toArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email
        ];
    }
}