-- =====================================================
-- Blossom Flower Shop - Database Schema
-- Import this file in phpMyAdmin to create everything
-- =====================================================

CREATE DATABASE IF NOT EXISTS flower_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE flower_shop;

-- ---------------------------------------------------
-- Table: users  (customers)
-- ---------------------------------------------------
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    phone VARCHAR(20) DEFAULT NULL,
    password VARCHAR(255) NOT NULL,
    address TEXT DEFAULT NULL,
    city VARCHAR(100) DEFAULT NULL,
    status ENUM('active','blocked') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------
-- Table: admins
-- ---------------------------------------------------
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------
-- Table: delivery_staff
-- ---------------------------------------------------
CREATE TABLE delivery_staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    phone VARCHAR(20) DEFAULT NULL,
    password VARCHAR(255) NOT NULL,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------
-- Table: categories
-- ---------------------------------------------------
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(120) NOT NULL UNIQUE,
    image VARCHAR(255) DEFAULT NULL,
    description VARCHAR(255) DEFAULT NULL,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------
-- Table: products (flowers)
-- ---------------------------------------------------
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    slug VARCHAR(180) NOT NULL UNIQUE,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    discount_price DECIMAL(10,2) DEFAULT NULL,
    stock INT NOT NULL DEFAULT 0,
    image VARCHAR(255) DEFAULT NULL,
    rating DECIMAL(2,1) DEFAULT 4.5,
    is_featured TINYINT(1) DEFAULT 0,
    is_bestseller TINYINT(1) DEFAULT 0,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------
-- Table: product_images (extra gallery images)
-- ---------------------------------------------------
CREATE TABLE product_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    image VARCHAR(255) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------
-- Table: cart
-- ---------------------------------------------------
CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------
-- Table: wishlist
-- ---------------------------------------------------
CREATE TABLE wishlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------
-- Table: orders
-- ---------------------------------------------------
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_number VARCHAR(30) NOT NULL UNIQUE,
    user_id INT NOT NULL,
    delivery_staff_id INT DEFAULT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(100) NOT NULL,
    pincode VARCHAR(15) DEFAULT NULL,
    payment_method ENUM('COD','UPI','CARD') NOT NULL DEFAULT 'COD',
    payment_status ENUM('pending','paid','failed') DEFAULT 'pending',
    order_status ENUM('pending','processing','shipped','out_for_delivery','delivered','cancelled') DEFAULT 'pending',
    subtotal DECIMAL(10,2) NOT NULL,
    discount DECIMAL(10,2) DEFAULT 0,
    delivery_fee DECIMAL(10,2) DEFAULT 0,
    total DECIMAL(10,2) NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (delivery_staff_id) REFERENCES delivery_staff(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ---------------------------------------------------
-- Table: order_items
-- ---------------------------------------------------
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(150) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------
-- Table: payments
-- ---------------------------------------------------
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    user_id INT NOT NULL,
    method ENUM('COD','UPI','CARD') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    transaction_id VARCHAR(100) DEFAULT NULL,
    status ENUM('pending','success','failed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------
-- Table: reviews
-- ---------------------------------------------------
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT NOT NULL DEFAULT 5,
    comment TEXT,
    status ENUM('visible','hidden') DEFAULT 'visible',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------
-- Table: enquiries (contact us form)
-- ---------------------------------------------------
CREATE TABLE enquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    subject VARCHAR(200) DEFAULT NULL,
    message TEXT NOT NULL,
    status ENUM('new','read','replied') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------
-- Table: offers (discount codes / promotions)
-- ---------------------------------------------------
CREATE TABLE offers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    code VARCHAR(50) NOT NULL UNIQUE,
    discount_percent INT NOT NULL,
    valid_from DATE DEFAULT NULL,
    valid_to DATE DEFAULT NULL,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------
-- Table: notifications
-- ---------------------------------------------------
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT DEFAULT NULL,
    title VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- SAMPLE DATA
-- =====================================================

-- Admin account -> email: admin@blossom.com | password: admin123
INSERT INTO admins (name, email, password) VALUES
('Blossom Admin', 'admin@blossom.com', '$2b$10$.ykWTsb9coX3dZLexFE5F.HYB1d91AVu2Vz5Nv4gLx2qf7c68Fdte');

-- Delivery staff -> email: delivery@blossom.com | password: delivery123
INSERT INTO delivery_staff (name, email, phone, password) VALUES
('Raj Kumar', 'delivery@blossom.com', '9876543210', '$2b$10$.4yHF5Itgh0pSQI6Plg/velzc/MRAu741yPMmMHSqVRyIQA.rVLkS');

-- Sample customer -> email: customer@blossom.com | password: customer123
INSERT INTO users (full_name, email, phone, password, address, city) VALUES
('Priya Sharma', 'customer@blossom.com', '9123456780', '$2b$10$nJ1hXbmlX8FrRlF4UbFB3uBlFyJitBKKWXfEN09aj0rI7esejzSw6', '221 Garden Lane', 'Rajkot');

-- Categories
INSERT INTO categories (name, slug, image, description) VALUES
('Roses', 'roses', 'roses.jpg', 'Classic and romantic roses for every occasion'),
('Lilies', 'lilies', 'lilies.jpg', 'Elegant lilies with a delicate fragrance'),
('Sunflowers', 'sunflowers', 'sunflowers.jpg', 'Bright sunflowers to brighten any day'),
('Tulips', 'tulips', 'tulips.jpg', 'Vibrant tulips in every colour'),
('Orchids', 'orchids', 'orchids.jpg', 'Exotic and long-lasting orchids'),
('Mixed Flowers', 'mixed-flowers', 'mixed.jpg', 'A colourful mix of seasonal blooms'),
('Bouquets', 'bouquets', 'bouquets.jpg', 'Hand-tied bouquets for gifting'),
('Birthday Flowers', 'birthday-flowers', 'birthday.jpg', 'Cheerful arrangements for birthdays'),
('Anniversary Flowers', 'anniversary-flowers', 'anniversary.jpg', 'Romantic arrangements for anniversaries'),
('Wedding Flowers', 'wedding-flowers', 'wedding.jpg', 'Beautiful arrangements for weddings'),
('Plants', 'plants', 'plants.jpg', 'Indoor and outdoor potted plants');

-- Products
INSERT INTO products (category_id, name, slug, description, price, discount_price, stock, image, rating, is_featured, is_bestseller) VALUES
(1, 'Red Rose Bouquet (12 Stems)', 'red-rose-bouquet-12', 'A classic bouquet of 12 fresh red roses, hand-tied with greenery and wrapped in premium paper.', 899.00, 749.00, 50, 'red-roses.jpg', 4.8, 1, 1),
(1, 'Pink Rose Basket', 'pink-rose-basket', 'Soft pink roses arranged in a decorative basket, perfect for a thoughtful gift.', 1099.00, NULL, 30, 'pink-roses.jpg', 4.6, 0, 1),
(2, 'White Lily Bunch', 'white-lily-bunch', 'Fragrant white lilies arranged elegantly, symbolising purity and grace.', 749.00, 649.00, 25, 'white-lily.jpg', 4.7, 1, 0),
(3, 'Sunflower Delight', 'sunflower-delight', 'A cheerful bunch of fresh sunflowers to brighten someone''s day.', 599.00, NULL, 40, 'sunflower.jpg', 4.5, 0, 1),
(4, 'Rainbow Tulip Bunch', 'rainbow-tulip-bunch', 'A vibrant mix of multicoloured tulips, freshly imported.', 999.00, 899.00, 20, 'tulips.jpg', 4.6, 1, 0),
(5, 'Purple Orchid Plant', 'purple-orchid-plant', 'An exotic purple orchid plant in a ceramic pot, blooms for weeks.', 1499.00, 1299.00, 15, 'orchid.jpg', 4.9, 1, 1),
(6, 'Seasonal Mixed Bouquet', 'seasonal-mixed-bouquet', 'A beautiful mix of seasonal flowers curated by our florists.', 849.00, NULL, 35, 'mixed-bouquet.jpg', 4.4, 0, 0),
(7, 'Elegant Hand-Tied Bouquet', 'elegant-hand-tied-bouquet', 'A designer hand-tied bouquet with premium blooms and satin ribbon.', 1299.00, 1099.00, 20, 'handtied.jpg', 4.8, 1, 0),
(8, 'Happy Birthday Flower Box', 'happy-birthday-flower-box', 'A festive flower box with balloons and a birthday card.', 1199.00, 999.00, 25, 'birthday-box.jpg', 4.7, 0, 1),
(9, 'Anniversary Rose Heart', 'anniversary-rose-heart', 'Red roses arranged in a heart shape box, perfect for anniversaries.', 1599.00, 1399.00, 15, 'anniversary-heart.jpg', 4.9, 1, 0),
(10, 'Bridal Wedding Bouquet', 'bridal-wedding-bouquet', 'An elegant white and blush bridal bouquet for the big day.', 2499.00, NULL, 10, 'wedding-bouquet.jpg', 5.0, 1, 0),
(11, 'Money Plant in Pot', 'money-plant-in-pot', 'A low-maintenance money plant, great for home or office.', 399.00, 349.00, 60, 'money-plant.jpg', 4.5, 0, 1);

-- Offers
INSERT INTO offers (title, code, discount_percent, valid_from, valid_to, status) VALUES
('Welcome Offer', 'BLOOM10', 10, '2026-01-01', '2026-12-31', 'active'),
('Anniversary Special', 'LOVE20', 20, '2026-01-01', '2026-12-31', 'active');

-- Sample review
INSERT INTO reviews (product_id, user_id, rating, comment) VALUES
(1, 1, 5, 'Absolutely gorgeous roses, fresh and beautifully arranged!');
