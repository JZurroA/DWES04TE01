<?php

// Clase UserDAO: Clase para manejar la capa de acceso a datos de usuarios

// Importar las clases necesarias
require_once __DIR__ . '/../../../core/DataBase.php';
require_once __DIR__ . '/../DTO/UserDTO.php';

class UserDAO {
    // Propiedad para almacenar la conexión a la base de datos
    private PDO $connection;

    // Constructor. Desde aquí se instancia la conexión a la base de datos
    public function __construct() {
        $this->connection = DataBase::getInstance()->getConnection();
    }

    // Métodos
    // Método para obtener todos los usuarios
    public function getUsers(): array {
        try {
            $query = "SELECT * FROM users";
            $statement = $this->connection->query($query);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            return array_map([$this, 'mapToUserDTO'], $result);
        } catch (PDOException $e) {
            throw new Exception("Error fetching users: " . $e->getMessage());
        }
    }

    // Método para obtener un usuario por su ID
    public function getUserById(int $id): ?UserDTO {
        try {
            $query = "SELECT * FROM users WHERE id = :id";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            return $result ? $this->mapToUserDTO($result) : null;
        } catch (PDOException $e) {
            throw new Exception("Error fetching user by ID: " . $e->getMessage());
        }
    }

    // Método para mapear los datos de la base de datos a un objeto DTO
    private function mapToUserDTO(array $row): UserDTO {
        if (!isset($row['id'], $row['name'], $row['surname'], $row['email'])) {
            throw new Exception("Invalid data format for UserDTO");
        }

        return new UserDTO(
            $row['id'],
            $row['name'],
            $row['surname'],
            $row['email']
        );
    }
}