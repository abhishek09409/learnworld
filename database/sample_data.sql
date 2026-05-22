-- =====================================================
-- SAMPLE DATA FOR TESTING
-- =====================================================
-- Run this if your dropdowns are empty

-- Categories
INSERT INTO categories (name, slug, status) VALUES
('Escorts', 'escorts', 'active'),
('Call Girls', 'callgirls', 'active'),
('VIP Service', 'vip-service', 'active'),
('Independent', 'independent', 'active');

-- States
INSERT INTO states (id, name) VALUES
(1, 'Delhi'),
(2, 'Maharashtra'),
(3, 'Karnataka'),
(4, 'Uttar Pradesh'),
(5, 'Rajasthan'),
(6, 'Gujarat'),
(7, 'Tamil Nadu'),
(8, 'West Bengal'),
(9, 'Telangana'),
(10, 'Punjab');

-- Cities for Delhi (state_id = 1)
INSERT INTO cities (state_id, name) VALUES
(1, 'Central Delhi'),
(1, 'Connaught Place'),
(1, 'Dwarka'),
(1, 'Karol Bagh'),
(1, 'Lajpat Nagar'),
(1, 'Nehru Place'),
(1, 'Paharganj'),
(1, 'Rohini'),
(1, 'Saket'),
(1, 'South Delhi');

-- Cities for Maharashtra (state_id = 2)
INSERT INTO cities (state_id, name) VALUES
(2, 'Mumbai'),
(2, 'Andheri'),
(2, 'Bandra'),
(2, 'Juhu'),
(2, 'Thane'),
(2, 'Pune'),
(2, 'Nashik'),
(2, 'Nagpur');

-- Cities for Karnataka (state_id = 3)
INSERT INTO cities (state_id, name) VALUES
(3, 'Bangalore'),
(3, 'Koramangala'),
(3, 'Whitefield'),
(3, 'Indiranagar'),
(3, 'Mysore'),
(3, 'Mangalore');

-- Cities for Uttar Pradesh (state_id = 4)
INSERT INTO cities (state_id, name) VALUES
(4, 'Lucknow'),
(4, 'Noida'),
(4, 'Ghaziabad'),
(4, 'Agra'),
(4, 'Varanasi'),
(4, 'Kanpur');

-- Cities for Rajasthan (state_id = 5)
INSERT INTO cities (state_id, name) VALUES
(5, 'Jaipur'),
(5, 'Jodhpur'),
(5, 'Udaipur'),
(5, 'Ajmer');

-- Cities for Gujarat (state_id = 6)
INSERT INTO cities (state_id, name) VALUES
(6, 'Ahmedabad'),
(6, 'Surat'),
(6, 'Vadodara'),
(6, 'Rajkot');

-- Cities for Tamil Nadu (state_id = 7)
INSERT INTO cities (state_id, name) VALUES
(7, 'Chennai'),
(7, 'Coimbatore'),
(7, 'Madurai'),
(7, 'Trichy');

-- Cities for West Bengal (state_id = 8)
INSERT INTO cities (state_id, name) VALUES
(8, 'Kolkata'),
(8, 'Howrah'),
(8, 'Siliguri');

-- Cities for Telangana (state_id = 9)
INSERT INTO cities (state_id, name) VALUES
(9, 'Hyderabad'),
(9, 'Secunderabad'),
(9, 'Warangal');

-- Cities for Punjab (state_id = 10)
INSERT INTO cities (state_id, name) VALUES
(10, 'Chandigarh'),
(10, 'Ludhiana'),
(10, 'Amritsar'),
(10, 'Jalandhar');
