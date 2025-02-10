<?php

// Clase ReservationDAO: Clase para manejar la capa de acceso a datos de Reserva

// Importar las clases necesarias
require_once '../core/DataBase.php';
require_once '../app/models/DTO/ReservationDTO.php';

class ReservationDAO {

    // Propiedad para almacenar la conexión a la base de datos
    private PDO $connection;

    // Constructor. Desde aquí se instancia la conexión a la base de datos
    public function __construct() {
        $this->connection = DataBase::getInstance()->getConnection();
    }

    // Métodos
    // Método para obtener una reserva por su ID
    public function getReservationById(int $id): ?ReservationDTO {
        try {
            $query = "SELECT * FROM reservations WHERE id = :id";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            return $result ? $this->mapToReservationDTO($result) : null;
        } catch (PDOException $e) {
            throw new Exception("Error getting reservation: " . $e->getMessage());
        }
    }

    // Método para crear una nueva reserva
    public function createReservation(int $bookId, int $userId, string $startDate, string $endDate): void {
        try {
            $query = "INSERT INTO reservations (book_id, user_id, start_date, end_date) VALUES (:book_id, :user_id, :start_date, :end_date)";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':book_id', $bookId, PDO::PARAM_INT);
            $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $statement->bindParam(':start_date', $startDate, PDO::PARAM_STR);
            $statement->bindParam(':end_date', $endDate, PDO::PARAM_STR);
            $statement->execute();
        } catch (PDOException $e) {
            throw new Exception("Error creating reservation: " . $e->getMessage());
        }
    }

    // Método para actualizar una reserva
    public function updateReservation(int $id, int $bookId, int $userId, string $startDate, string $endDate): void {
        try {
            $query = "UPDATE reservations SET book_id = :book_id, user_id = :user_id, start_date = :start_date, end_date = :end_date WHERE id = :id";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':book_id', $bookId, PDO::PARAM_INT);
            $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $statement->bindParam(':start_date', $startDate, PDO::PARAM_STR);
            $statement->bindParam(':end_date', $endDate, PDO::PARAM_STR);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
        } catch (PDOException $e) {
            throw new Exception("Error updating reservation: " . $e->getMessage());
        }
            
    }

    // Método para eliminar una reserva	
    public function deleteReservation(int $id): bool {
        try {
            $query = "DELETE FROM reservations WHERE id = :id";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $success = $statement->execute(); // Devuelve true si la eliminación fue exitosa
            return $success; // Retornamos el valor de éxito
        } catch(PDOException $e) {
            throw new Exception("Error deleting reservation: " . $e->getMessage());
        }
    }

    // Método para verificar si un libro está reservado en las fechas proporcionadas
    public function isBookReserved(int $bookId, string $startDate, string $endDate, int $excludeId = null): bool {
        $query = "SELECT COUNT(*) FROM reservations
                  WHERE book_id = :book_id
                  AND (start_date <= :end_date AND end_date >= :start_date)";
        
        if ($excludeId) {
            $query .= " AND id != :exclude_id";  // Excluir la reserva que estamos actualizando
        }
    
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':book_id', $bookId);
        $stmt->bindParam(':start_date', $startDate);
        $stmt->bindParam(':end_date', $endDate);
    
        if ($excludeId) {
            $stmt->bindParam(':exclude_id', $excludeId);  // Pasar el ID de la reserva a excluir
        }
    
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    
    // Método para obtener el último ID insertado
    public function getLastInsertedId(): int {
        return (int) $this->connection->lastInsertId();
    }    

    // Método para mapear los datos de la base de datos a un objeto DTO
    private function mapToReservationDTO(array $row): ReservationDTO {
        return new ReservationDTO(
            (int)$row['id'],           // id
            (int)$row['book_id'],      // bookId
            (int)$row['user_id'],      // userId
            $row['start_date'],        // startDate (string)
            $row['end_date']           // endDate (string)
        );
    }
}