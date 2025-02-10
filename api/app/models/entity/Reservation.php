<?php

// Clase Reservation: Clase que representa la entidad Reserva y sus reglas de negocio
class Reservation {
    // Atributos
    private ?int $id;
    private int $bookId;
    private int $userId;
    private string $startDate;
    private string $endDate;

    private function __construct(?int $id, int $bookId, int $userId, string $startDate, string $endDate) {
        // Solo inicializa las propiedades, sin validaciones
        $this->id = $id;
        $this->bookId = $bookId;
        $this->userId = $userId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;

        $this->validateDates();
    }

    
    //Valida las reglas de negocio asociadas a la reserva.
    private function validateDates(): void {
        $today = new DateTime();
        $today->setTime(0, 0, 0);
        $reservationStartDate = new DateTime($this->startDate);
        $reservationEndDate = new DateTime($this->endDate);

        if ($reservationStartDate < $today) {
            throw new Exception('Start date cannot be in the past.');
        }

        if ($reservationEndDate <= $reservationStartDate) {
            throw new Exception('End date must be after start date.');
        }
    }

    // Método para crear una nueva reserva a partir de un DTO
    public static function createFromDTO(ReservationDTO $dto): self {
        try {
            return new self(
                $dto->getId(),
                $dto->getBookId(),
                $dto->getUserId(),
            $dto->getStartDate(), // Intentar convertir
            $dto->getEndDate()   // Intentar convertir
            );
        } catch (Exception $e) {
            throw new Exception('Invalid date format in DTO: ' . $e->getMessage());
        }
    }       

    // Método para convertir la entidad a un DTO
    public function toDTO(): ReservationDTO {
        return new ReservationDTO(
            $this->id,
            $this->bookId,
            $this->userId,
            $this->startDate, // Convierte DateTime a string
            $this->endDate   // Convierte DateTime a string
        );
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
}
