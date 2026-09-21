-- 1. Bảng Người dùng
CREATE TABLE User (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    password_hash VARCHAR(255) NOT NULL,
    user_type ENUM('elderly', 'pwd', 'caregiver', 'admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Bảng Hồ sơ tiếp cận
CREATE TABLE Accessibility_Profile (
    profile_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    mobility_level VARCHAR(50),
    has_wheelchair BOOLEAN DEFAULT FALSE,
    visual_impairment VARCHAR(50),
    notes TEXT,
    FOREIGN KEY (user_id) REFERENCES User(user_id) ON DELETE CASCADE
);

-- 3. Bảng Người đi cùng
CREATE TABLE Companion (
    companion_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    relationship VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES User(user_id) ON DELETE CASCADE
);

-- 4. Bảng Điểm đến
CREATE TABLE Destination (
    destination_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    address VARCHAR(255) NOT NULL,
    city VARCHAR(100),
    description TEXT
);

-- 5. Bảng Dịch vụ du lịch
CREATE TABLE Service (
    service_id INT AUTO_INCREMENT PRIMARY KEY,
    destination_id INT NOT NULL,
    service_name VARCHAR(150) NOT NULL,
    service_type VARCHAR(50),
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (destination_id) REFERENCES Destination(destination_id) ON DELETE CASCADE
);

-- 6. Bảng Thông tin tiếp cận đặc thù (Có ràng buộc CHECK)
CREATE TABLE Accessibility_Info (
    info_id INT AUTO_INCREMENT PRIMARY KEY,
    service_id INT NOT NULL,
    ramp_slope DECIMAL(4,2) CHECK (ramp_slope <= 12.0),
    door_width DECIMAL(5,2) CHECK (door_width >= 70.0),
    has_elevator BOOLEAN DEFAULT FALSE,
    has_accessible_toilet BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (service_id) REFERENCES Service(service_id) ON DELETE CASCADE
);

-- 7. Bảng Hình ảnh
CREATE TABLE Image (
    image_id INT AUTO_INCREMENT PRIMARY KEY,
    service_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    description TEXT,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (service_id) REFERENCES Service(service_id) ON DELETE CASCADE
);

-- 8. Bảng Đặt dịch vụ
CREATE TABLE Booking (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    service_id INT NOT NULL,
    booking_date DATETIME NOT NULL,
    status ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
    total_price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES User(user_id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES Service(service_id) ON DELETE CASCADE
);

-- 9. Bảng Đánh giá
CREATE TABLE Review (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    service_id INT NOT NULL,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES User(user_id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES Service(service_id) ON DELETE CASCADE
);

-- 10. Bảng Yêu cầu hỗ trợ
CREATE TABLE Support_Request (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    status ENUM('open', 'in_progress', 'resolved') DEFAULT 'open',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES User(user_id) ON DELETE CASCADE
);
CREATE INDEX idx_accessibility_search ON Accessibility_Info(ramp_slope, door_width);