<?php

require_once __DIR__ . '/../DAO/UserDAO.php';

class UserDTO implements JsonSerializable {

    private $id;
    private $name;
    private $surname;
    private $email;

    private UserDAO $userDAO;

    public function __construct(int $id = null, string $name = null, string $surname = null, string $email = null) {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->userDAO = new UserDAO();
    }

    public function getUsers(): array {
        return $this->userDAO->getUsers();  // Se obtiene la lista de libros desde el DAO
    }

    // Obtener un libro por ID
    public function getUserById(int $id): ?UserDTO {
        return $this->userDAO->getUserById($id);  // Se obtiene un solo libro por ID desde el DAO
    } 

    /**
     * Get the value of id
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Get the value of name
     */
    public function getName(){
        return $this->name;
    }

    /**
     * Get the value of surname
     */
    public function getSurname(){
        return $this->surname;
    }

    /**
     * Get the value of email
     */
    public function getEmail(){
        return $this->email;
    }

    /**
     * Set the value of id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Set the value of name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Set the value of surname
     */
    public function setSurname($surname) {
        $this->surname = $surname;
    }

    /**
     * Set the value of email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    public function jsonSerialize():mixed {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email
        ];
    }
}