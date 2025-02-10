<?php

// Clase ReservationController: Controlador para manejar las reservas

// Incluir archivos requeridos
require_once __DIR__ . '/../models/DTO/ReservationDTO.php';
require_once __DIR__ . '/../models/DAO/ReservationDAO.php';
require_once __DIR__ . '/../models/Entity/Reservation.php';

class ReservationController {
    private ReservationDTO $reservationDTO;

    public function __construct() {
        $this->reservationDTO = new ReservationDTO();
    }

    // Método para crear una reserva
    public function create(): void {
        try {
            $input = json_decode(file_get_contents('php://input'), true);

            // Validar campos requeridos
            if (empty($input['bookId']) || empty($input['userId']) || empty($input['startDate']) || empty($input['endDate'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required fields: bookId, userId, startDate, endDate']);
                return;
            }

            // Crear DTO
            $this->reservationDTO->setBookId($input['bookId']);
            $this->reservationDTO->setUserId($input['userId']);
            $this->reservationDTO->setStartDate($input['startDate']);
            $this->reservationDTO->setEndDate($input['endDate']);

            // Intentar crear la entidad
            try {
                $reservation = Reservation::createFromDTO($this->reservationDTO);
            } catch (Exception $e) {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => $e->getMessage()]);
                return;
            }

            if ($this->reservationDTO->isBookReserved($reservation->getBookId(), $reservation->getStartDate(), $reservation->getEndDate())) {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'The book is already reserved during this period.']);
                return;
            } else {
                $this->reservationDTO->createReservation($reservation->getBookId(), $reservation->getUserId(), $reservation->getStartDate(), $reservation->getEndDate());
                $lastInsertedId = $this->reservationDTO->getLastInsertedId();
                header('Content-Type: application/json');
                http_response_code(201);

                // Convertir la reserva en un DTO
                $reservationDTO = $reservation->toDTO();

                // Establecer el ID insertado
                $reservationDTO->setId($lastInsertedId);

                // Devolver el DTO en formato JSON
                echo json_encode($reservationDTO);
            }

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // Método para actualizar una reserva
    public function update(int $id): void {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
    
            // Validar campos requeridos (excepto id, que ya viene en la URL)
            if (empty($input['bookId']) || empty($input['userId']) || empty($input['startDate']) || empty($input['endDate'])) {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'Missing required fields: bookId, userId, startDate, endDate']);
                return;
            }
    
            // Crear DTO y asignar la id desde la URL
            $this->reservationDTO->setId($id);  // Asegúrate de que se asigna el id
            $this->reservationDTO->setBookId($input['bookId']);
            $this->reservationDTO->setUserId($input['userId']);
            $this->reservationDTO->setStartDate($input['startDate']);
            $this->reservationDTO->setEndDate($input['endDate']);
    
            // Intentar crear la entidad
            try {
                $reservation = Reservation::createFromDTO($this->reservationDTO);
            } catch (Exception $e) {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => $e->getMessage()]);
                return;
            }
    
            // Llamada a la función isBookReserved y pasando el ID de la reserva para excluirla
            if ($this->reservationDTO->isBookReserved($reservation->getBookId(), $reservation->getStartDate(), $reservation->getEndDate(), $id)) {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'The book is already reserved during this period.']);
                return;
            } else {
                $this->reservationDTO->updateReservation(
                    $this->reservationDTO->getId(),
                    $reservation->getBookId(),
                    $reservation->getUserId(),
                    $reservation->getStartDate(),
                    $reservation->getEndDate()
                );
                header('Content-Type: application/json');
                http_response_code(200);
                echo json_encode(['message' => 'Reservation updated successfully']);
            }
    
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }    

    // Método para eliminar una reserva
    public function destroy(int $id): void  {
        try {

            $searchedId = $this->reservationDTO->getReservationById($id);
            if (!$searchedId) {
                header('Content-Type: application/json');
                http_response_code(404);
                echo json_encode(['error' => 'Reservation not found']);
                return;
            }
            // Pasar la ID a la capa DTO para gestionar la eliminación
            $this->reservationDTO->deleteReservation($id);
            
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode(['message' => 'Reservation deleted successfully']);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'details' => $e->getMessage()]);
        }
    }    
}
