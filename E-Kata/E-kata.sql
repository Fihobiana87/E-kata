-- E-Kata - Base de données e-commerce (MySQL)
-- Encodage recommandé : utf8mb4

DROP DATABASE IF EXISTS ekata;
CREATE DATABASE ekata CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ekata;

-- Utilisateurs
CREATE TABLE users (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL,
  phone VARCHAR(40) NULL,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('customer','admin') NOT NULL DEFAULT 'customer',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uniq_users_email (email)
) ENGINE=InnoDB;

-- Produits
CREATE TABLE products (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(200) NOT NULL,
  slug VARCHAR(220) NOT NULL,
  gender ENUM('homme','femme','unisex') NOT NULL DEFAULT 'unisex',
  category VARCHAR(80) NOT NULL, -- t-shirt, chemise, pantalon...
  description TEXT NULL,
  price_cents INT UNSIGNED NOT NULL,
  promo_price_cents INT UNSIGNED NULL,
  stock INT NOT NULL DEFAULT 0,
  is_new TINYINT(1) NOT NULL DEFAULT 0,
  is_featured TINYINT(1) NOT NULL DEFAULT 0,
  image VARCHAR(255) NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uniq_products_slug (slug),
  KEY idx_products_gender (gender),
  KEY idx_products_category (category),
  KEY idx_products_active (is_active)
) ENGINE=InnoDB;

-- Commandes
CREATE TABLE orders (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id INT UNSIGNED NOT NULL,
  order_number VARCHAR(30) NOT NULL,
  customer_name VARCHAR(120) NOT NULL,
  address VARCHAR(255) NOT NULL,
  phone VARCHAR(40) NOT NULL,
  payment_method ENUM('orange_money','airtel_money','mvola','cod') NOT NULL,
  status ENUM('pending','paid','validated','shipped','cancelled') NOT NULL DEFAULT 'pending',
  total_cents INT UNSIGNED NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uniq_orders_order_number (order_number),
  KEY idx_orders_user (user_id),
  CONSTRAINT fk_orders_user FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Détails commande
CREATE TABLE order_items (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  order_id INT UNSIGNED NOT NULL,
  product_id INT UNSIGNED NOT NULL,
  product_name VARCHAR(200) NOT NULL,
  unit_price_cents INT UNSIGNED NOT NULL,
  quantity INT UNSIGNED NOT NULL,
  line_total_cents INT UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  KEY idx_order_items_order (order_id),
  KEY idx_order_items_product (product_id),
  CONSTRAINT fk_order_items_order FOREIGN KEY (order_id) REFERENCES orders(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_order_items_product FOREIGN KEY (product_id) REFERENCES products(id)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Données de démo
INSERT INTO users (name, email, phone, password_hash, role) VALUES
('Admin E-Kata', 'admin@ekata.local', '000000000', 'Admin123!', 'admin');
-- Mot de passe admin par défaut : Admin123! (à changer après import)

INSERT INTO products (name, slug, gender, category, description, price_cents, promo_price_cents, stock, is_new, is_featured, image, is_active) VALUES
('T-shirt Neo Black', 't-shirt-neo-black', 'homme', 't-shirt', 'Coton premium, coupe moderne. Signature E-Kata.', 129900, NULL, 25, 1, 1, 'prod_neo_black.jpg', 1),
('Chemise Skyline', 'chemise-skyline', 'homme', 'chemise', 'Texture légère, style minimaliste impactant.', 189900, 159900, 18, 0, 1, 'prod_skyline.jpg', 1),
('Pantalon Flux', 'pantalon-flux', 'homme', 'pantalon', 'Confort technique, look futuriste.', 219900, NULL, 12, 1, 0, 'prod_flux.jpg', 1),
('T-shirt Aura White', 't-shirt-aura-white', 'femme', 't-shirt', 'Doux, respirant, lignes épurées.', 129900, 109900, 30, 1, 1, 'prod_aura_white.jpg', 1),
('Chemise Prism', 'chemise-prism', 'femme', 'chemise', 'Coupe élégante, finitions premium.', 199900, NULL, 14, 0, 0, 'prod_prism.jpg', 1),
('Pantalon Vector', 'pantalon-vector', 'femme', 'pantalon', 'Silhouette moderne, matière résistante.', 229900, 199900, 10, 0, 1, 'prod_vector.jpg', 1);

