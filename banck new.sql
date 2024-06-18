CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    full_name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE Destinations (
    destination_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE Bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    package_id INT,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    number_of_people INT,
    total_price DECIMAL(10, 2),
    status VARCHAR(50) DEFAULT 'Pending',
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (package_id) REFERENCES Packages(package_id)
);
CREATE TABLE Reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    package_id INT,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    comment TEXT,
    review_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (package_id) REFERENCES Packages(package_id)
);
INSERT INTO Destinations (name, description, image_url) VALUES
('Paris, França', 'A cidade do amor e da luz.', 'paris.jpg'),
('Nova York, EUA', 'A cidade que nunca dorme.', 'new_york.jpg'),
('Tóquio, Japão', 'A capital moderna e tradicional do Japão.', 'tokyo.jpg');
INSERT INTO Packages (destination_id, name, description, price, start_date, end_date, image_url) VALUES
(1, 'Pacote Romântico em Paris', '5 dias em Paris para casais.', 1500.00, '2024-07-01', '2024-07-06', 'paris_package.jpg'),
(2, 'Aventura em Nova York', '7 dias explorando Nova York.', 2000.00, '2024-08-01', '2024-08-08', 'new_york_package.jpg'),
(3, 'Descubra Tóquio', '10 dias na vibrante capital do Japão.', 3000.00, '2024-09-01', '2024-09-11', 'tokyo_package.jpg');
SELECT 
    p.package_id, 
    p.name AS package_name, 
    d.name AS destination_name, 
    p.description, 
    p.price, 
    p.start_date, 
    p.end_date, 
    p.image_url
FROM 
    Packages p
JOIN 
    Destinations d ON p.destination_id = d.destination_id;INSERT INTO Bookings (user_id, package_id, number_of_people, total_price) VALUES 
(1, 2, 2, 4000.00);
SELECT 
    b.booking_id, 
    p.name AS package_name, 
    d.name AS destination_name, 
    b.booking_date, 
    b.number_of_people, 
    b.total_price, 
    b.status
FROM 
    Bookings b
JOIN 
    Packages p ON b.package_id = p.package_id
JOIN 
    Destinations d ON p.destination_id = d.destination_id
WHERE 
    b.user_id = 1;
INSERT INTO Reviews (user_id, package_id, rating, comment) VALUES 
(1, 2, 5, 'Foi uma experiência incrível!');