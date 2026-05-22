-- =====================================================
-- ESCORTS TABLE SCHEMA
-- =====================================================
-- Main table for storing escort ads
-- Based on your existing DB structure (from screenshot)

CREATE TABLE IF NOT EXISTS `escorts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_slug` varchar(100) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_slug` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL UNIQUE,
  `description` text NOT NULL,
  `age` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `telegram` varchar(100) DEFAULT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,
  `status` enum('active','pending','rejected') DEFAULT 'pending',
  `profile_image` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `category_slug` (`category_slug`),
  KEY `state_id` (`state_id`),
  KEY `city_slug` (`city_slug`),
  KEY `status` (`status`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add indexes for better performance
CREATE INDEX idx_slug ON escorts(slug);
CREATE INDEX idx_active ON escorts(status, created_at);
