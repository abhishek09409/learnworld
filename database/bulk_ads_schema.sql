-- =====================================================
-- BULK AD GENERATION SYSTEM - DATABASE SCHEMA
-- =====================================================

-- Content Templates Table
CREATE TABLE IF NOT EXISTS `content_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_slug` varchar(100) DEFAULT NULL,
  `type` enum('title','description','prefix','suffix') NOT NULL,
  `content` text NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_slug` (`category_slug`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Bulk Generation Batches
CREATE TABLE IF NOT EXISTS `bulk_batches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_slug` varchar(100) NOT NULL,
  `total_ads` int(11) NOT NULL,
  `generated_ads` int(11) DEFAULT 0,
  `status` enum('pending','processing','completed','failed') DEFAULT 'pending',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `completed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Phrase Variations for Humanization
CREATE TABLE IF NOT EXISTS `phrase_variations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phrase_group` varchar(50) NOT NULL COMMENT 'e.g., greeting, service, location, age_desc',
  `phrase` text NOT NULL,
  `weight` int(11) DEFAULT 1 COMMENT 'Higher weight = more frequency',
  `status` enum('active','inactive') DEFAULT 'active',
  PRIMARY KEY (`id`),
  KEY `phrase_group` (`phrase_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert Default Templates
INSERT INTO `content_templates` (`category_slug`, `type`, `content`) VALUES
-- TITLES
(NULL, 'title', '{adjective} {service_type} Girl Available in {city}'),
(NULL, 'title', '{city} {adjective} Escort Service - {availability}'),
(NULL, 'title', 'High Class {service_type} in {city} | {adjective}'),
(NULL, 'title', '{adjective} Call Girl in {city} - Independent'),
(NULL, 'title', 'VIP {service_type} Service {city} {availability}'),
(NULL, 'title', '{city} Premium Escort - {adjective} and {adjective}'),
(NULL, 'title', 'Independent {adjective} Girl in {city}'),
(NULL, 'title', '{adjective} {service_type} Available Now in {city}'),

-- DESCRIPTIONS
(NULL, 'description', 'Hello gentlemen! I am {name}, a {age} year old {adjective} girl providing {service_type} services in {city}. {personality} {availability_desc} {contact_info}'),
(NULL, 'description', 'Hi there! Looking for {adjective} companion in {city}? I am {name}, {age} years young, {physical_desc}. {service_desc} {contact_info}'),
(NULL, 'description', 'Hey! I am {name} from {city}. {age} year old {adjective} and {adjective} girl. {personality} {service_desc} {availability_desc} {contact_info}'),
(NULL, 'description', 'Welcome! {name} here, offering premium {service_type} in {city}. I am {age} years old, {physical_desc}. {personality} {contact_info}'),
(NULL, 'description', 'Hello dear! I am {name}, your perfect {adjective} companion in {city}. Age {age}, {physical_desc}. {service_desc} {availability_desc} {contact_info}');

-- Insert Phrase Variations
INSERT INTO `phrase_variations` (`phrase_group`, `phrase`, `weight`) VALUES
-- ADJECTIVES
('adjective', 'Beautiful', 3),
('adjective', 'Gorgeous', 3),
('adjective', 'Stunning', 2),
('adjective', 'Attractive', 3),
('adjective', 'Charming', 2),
('adjective', 'Elegant', 2),
('adjective', 'Lovely', 3),
('adjective', 'Hot', 2),
('adjective', 'Sexy', 2),
('adjective', 'Premium', 1),
('adjective', 'High Class', 1),
('adjective', 'VIP', 1),

-- SERVICE TYPES
('service_type', 'Escort', 3),
('service_type', 'Call Girl', 3),
('service_type', 'Companion', 2),
('service_type', 'Service', 2),

-- AVAILABILITY
('availability', 'Available Now', 3),
('availability', '24/7 Available', 2),
('availability', 'Call Anytime', 3),
('availability', 'Ready to Meet', 2),
('availability', 'Instant Service', 1),

-- AVAILABILITY DESCRIPTIONS
('availability_desc', 'I am available 24/7 for your convenience.', 2),
('availability_desc', 'Call me anytime, I am ready to meet.', 2),
('availability_desc', 'Available now for incall and outcall both.', 2),
('availability_desc', 'Flexible timings, call me when you need.', 1),
('availability_desc', 'Ready to provide service anytime you want.', 2),

-- PERSONALITY
('personality', 'I am friendly and easy to talk with.', 2),
('personality', 'Very genuine and down to earth person.', 2),
('personality', 'I love meeting new people and having good conversations.', 1),
('personality', 'Open minded and fun loving girl.', 2),
('personality', 'Professional and discreet companion.', 2),
('personality', 'I guarantee you will have amazing time with me.', 1),

-- PHYSICAL DESCRIPTIONS
('physical_desc', 'well maintained figure and glowing skin', 2),
('physical_desc', 'attractive personality with great smile', 2),
('physical_desc', 'beautiful eyes and long hair', 1),
('physical_desc', 'perfect body shape and smooth skin', 2),
('physical_desc', 'stunning looks and charming personality', 2),

-- SERVICE DESCRIPTIONS
('service_desc', 'I provide complete satisfaction and memorable experience.', 2),
('service_desc', 'You will enjoy every moment spent with me.', 2),
('service_desc', 'I offer premium quality service with full dedication.', 1),
('service_desc', 'Hygienic and safe service guaranteed.', 2),
('service_desc', 'Your satisfaction is my priority.', 2),

-- CONTACT INFO
('contact_info', 'Call or WhatsApp me now to book your appointment.', 3),
('contact_info', 'Contact me for booking and rate details.', 2),
('contact_info', 'Genuine people only, call me for more info.', 2),
('contact_info', 'WhatsApp me for quick response and booking.', 2),
('contact_info', 'Call me directly, I will be waiting for your call.', 2);

-- Female Names for randomization
INSERT INTO `phrase_variations` (`phrase_group`, `phrase`, `weight`) VALUES
('female_names', 'Priya', 3),
('female_names', 'Riya', 3),
('female_names', 'Anjali', 2),
('female_names', 'Neha', 3),
('female_names', 'Pooja', 3),
('female_names', 'Simran', 2),
('female_names', 'Kavya', 2),
('female_names', 'Diya', 2),
('female_names', 'Isha', 2),
('female_names', 'Maya', 2),
('female_names', 'Sana', 3),
('female_names', 'Tanya', 2),
('female_names', 'Shreya', 2),
('female_names', 'Aarti', 2),
('female_names', 'Komal', 2);
