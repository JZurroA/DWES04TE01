<?php


// Clase ReservationDTO: Clase que representa un objeto de transferencia de datos de Reserva.
// Implementa la interfaz JsonSerializable para poder serializar el objeto a formato JSON.
class ReservationDTO implements JsonSerializable {

    // Atributos
    private ?int $id;
    private int $bookId;
    private int $userId;
    private string $startDate;
    private string $endDate;

    private ReservationDAO $reservationDAO;

    // Constructor
    public function __construct(int $id = null, int $bookId = 0, int $userId = 0, string $startDate = '', string $endDate= '') {
        $this->id = $id;
        $this->bookId = $bookId;
        $this->userId = $userId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->reservationDAO = new ReservationDAO();
    }

    // Métodos
    // Método para obtener y transferir los datos de una reserva por su ID desde la capa DAO.
    public function getReservationById(int $id): ?ReservationDTO {
        return $this->reservationDAO->getReservationById($id);
    }    

    // Método para transferir los datos de una nueva reserva a la capa DAO.
    public function createReservation(int $bookId, int $userId, string $startDate, string $endDate ): void {
        $this->reservationDAO->createReservation($bookId, $userId, $startDate,  $endDate);
    }

    // Método para transferir los datos de una reserva actualizada a la capa DAO.
    public function updateReservation(int $id, int $bookId, int $userId, string $startDate, string $endDate): void {
        $this->reservationDAO->updateReservation($id, $bookId, $userId, $startDate, $endDate);
    }

    // Método para transferir el ID de una reserva a eliminar a la capa DAO.
    public function deleteReservation(int $id): bool {
        return $this->reservationDAO->deleteReservation($id);
    }     

    // Verifica si el libro está reservado en las fechas proporcionadas.
    public function isBookReserved(int $bookId, string $startDate, string $endDate, ?int $excludeId = null): bool {
        return $this->reservationDAO->isBookReserved($bookId, $startDate, $endDate, $excludeId);
    }    

    // Método para obtener el último ID insertado.
    public function getLastInsertedId(): int {
        return $this->reservationDAO->getLastInsertedId();
    }

    // Getters
    public function getId(): ?int {
        return $this->id;
    }

    public function getBookId(): int {
        return $this->bookId;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function getStartDate(): string {
        return $this->startDate;
    }

    public function getEndDate(): string {
        return $this->endDate;
    }

    // Setters
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setBookId(int $bookId): void {
        $this->bookId = $bookId;
    }

    public function setUserId(int $userId): void {
        $this->userId = $userId;
    }

    public function setStartDate(string $startDate): void {
        $this->startDate = $startDate;
    }

    public function setEndDate(string $endDate): void {
        $this->endDate = $endDate;
    }

    // Implementación de JsonSerializable
    public function jsonSerialize(): array {
        return [
            'id' => $this->id,
            'bookId' => $this->bookId,
            'userId' => $this->userId,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ];
    }
}
