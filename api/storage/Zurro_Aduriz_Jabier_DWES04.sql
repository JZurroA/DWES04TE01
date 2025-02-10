-- Autor: Jabier Zurro Aduriz
-- Fecha: 02/02/2025
-- Asignatura: DWES
-- UD: 4 - Creación de Servicios Web (APIRest)
-- Descripción: Script de creación de la base de datos para el proyecto de la UD4
CREATE SCHEMA IF NOT EXISTS library;

USE library;

CREATE TABLE books (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    genre VARCHAR(255) DEFAULT 'Desconocido'
);

INSERT INTO books (title, author, genre) VALUES
('Cien años de soledad', 'Gabriel García Márquez', 'Novela'),
('1984', 'George Orwell', 'Ciencia ficción'),
('El señor de los anillos', 'J.R.R. Tolkien', 'Fantasía'),
('El principito', 'Antoine de Saint-Exupéry', 'Infantil'),
('Matar a un ruiseñor', 'Harper Lee', 'Drama'),
('Don Quijote de la Mancha', 'Miguel de Cervantes', 'Aventura'),
('Orgullo y prejuicio', 'Jane Austen', 'Novela');

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    surname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE
);

INSERT INTO users (name, surname, email) VALUES
('Ana', 'García', 'ana.garcia@birt.eus'),
('Luis', 'Pérez', 'luis.perez@birt.eus'),
('María', 'Rodríguez', 'maria.rodriguez@ejemplo.es'),
('Carlos', 'Sánchez', 'carlos.sanchez@correo.com'),
('Laura', 'Martínez', 'laura.martinez@example.com'),
('Javier', 'López', 'javier.lopez@correo.es'),
('Elena', 'Moreno', 'elena.moreno@example.com');

CREATE TABLE reservations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    book_id INT NOT NULL,
    user_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    CONSTRAINT fk_book_res FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
    CONSTRAINT fk_user_res FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO reservations (book_id, user_id, start_date, end_date) VALUES
(1, 3, '2024-12-01', '2024-12-15'),
(2, 1, '2024-12-05', '2024-12-10'),
(3, 4, '2024-12-08', '2024-12-20'),
(4, 1, '2024-11-12', '2024-11-19'),
(5, 7, '2024-12-03', '2024-12-18'),
(6, 2, '2024-12-05', '2024-12-05'),
(6, 6, '2024-12-12', '2024-12-20');