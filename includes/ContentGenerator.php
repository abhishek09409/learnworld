<?php
/**
 * =====================================================
 * CONTENT GENERATOR - HUMANIZED TEMPLATE SYSTEM
 * =====================================================
 * Generates unique, humanized content for bulk ads
 * using templates and random variations
 */

class ContentGenerator {
    
    private $conn;
    private $cache = [];
    
    public function __construct($db_connection) {
        $this->conn = $db_connection;
        $this->loadPhrases();
    }
    
    /**
     * Load all phrase variations into memory for faster access
     */
    private function loadPhrases() {
        $query = "SELECT phrase_group, phrase, weight FROM phrase_variations WHERE status='active'";
        $result = $this->conn->query($query);
        
        while($row = $result->fetch_assoc()) {
            $group = $row['phrase_group'];
            $weight = $row['weight'];
            
            if(!isset($this->cache[$group])) {
                $this->cache[$group] = [];
            }
            
            // Add phrase multiple times based on weight for probability
            for($i = 0; $i < $weight; $i++) {
                $this->cache[$group][] = $row['phrase'];
            }
        }
    }
    
    /**
     * Get random phrase from a group
     */
    private function getRandomPhrase($group) {
        if(!isset($this->cache[$group]) || empty($this->cache[$group])) {
            return '';
        }
        return $this->cache[$group][array_rand($this->cache[$group])];
    }
    
    /**
     * Generate unique title
     */
    public function generateTitle($city_name, $category_slug = null) {
        
        // Get random title template
        $query = "SELECT content FROM content_templates WHERE type='title' AND status='active'";
        if($category_slug) {
            $query .= " AND (category_slug='$category_slug' OR category_slug IS NULL)";
        }
        $query .= " ORDER BY RAND() LIMIT 1";
        
        $result = $this->conn->query($query);
        $template = $result->fetch_assoc()['content'] ?? '{adjective} Call Girl in {city}';
        
        // Replace placeholders
        $title = $this->replacePlaceholders($template, [
            'city' => $city_name,
            'category' => $category_slug
        ]);
        
        return $this->cleanText($title);
    }
    
    /**
     * Generate unique description
     */
    public function generateDescription($city_name, $age, $phone, $category_slug = null) {
        
        // Get random description template
        $query = "SELECT content FROM content_templates WHERE type='description' AND status='active'";
        if($category_slug) {
            $query .= " AND (category_slug='$category_slug' OR category_slug IS NULL)";
        }
        $query .= " ORDER BY RAND() LIMIT 1";
        
        $result = $this->conn->query($query);
        $template = $result->fetch_assoc()['content'] ?? 
                   'Hello! I am {name}, {age} year old {adjective} girl in {city}. {contact_info}';
        
        // Replace placeholders
        $description = $this->replacePlaceholders($template, [
            'city' => $city_name,
            'age' => $age,
            'phone' => $phone,
            'category' => $category_slug
        ]);
        
        return $this->cleanText($description);
    }
    
    /**
     * Replace all placeholders in template
     */
    private function replacePlaceholders($template, $data = []) {
        
        $replacements = [
            '{city}' => $data['city'] ?? 'Delhi',
            '{age}' => $data['age'] ?? rand(21, 35),
            '{phone}' => $data['phone'] ?? '9XXXXXXXXX',
            
            // Random variations
            '{name}' => $this->getRandomPhrase('female_names'),
            '{adjective}' => $this->getRandomPhrase('adjective'),
            '{service_type}' => $this->getRandomPhrase('service_type'),
            '{availability}' => $this->getRandomPhrase('availability'),
            '{availability_desc}' => $this->getRandomPhrase('availability_desc'),
            '{personality}' => $this->getRandomPhrase('personality'),
            '{physical_desc}' => $this->getRandomPhrase('physical_desc'),
            '{service_desc}' => $this->getRandomPhrase('service_desc'),
            '{contact_info}' => $this->getRandomPhrase('contact_info'),
        ];
        
        $text = $template;
        
        // Replace all placeholders
        foreach($replacements as $key => $value) {
            $text = str_replace($key, $value, $text);
        }
        
        // Handle multiple adjectives in same sentence
        $text = preg_replace_callback('/\{adjective\}/', function($matches) {
            return $this->getRandomPhrase('adjective');
        }, $text);
        
        return $text;
    }
    
    /**
     * Clean and humanize text
     */
    private function cleanText($text) {
        
        // Remove extra spaces
        $text = preg_replace('/\s+/', ' ', $text);
        
        // Trim
        $text = trim($text);
        
        // Capitalize first letter
        $text = ucfirst($text);
        
        // Random variations for humanization
        $text = $this->addHumanTouch($text);
        
        return $text;
    }
    
    /**
     * Add human touch to content
     */
    private function addHumanTouch($text) {
        
        // Randomly add/remove punctuation marks for variation
        $variations = [
            '!' => ['!', '!!', '.'],
            '.' => ['.', '..', '!'],
        ];
        
        // Sometimes add emoji (5% chance)
        if(rand(1, 20) == 1) {
            $emojis = ['😊', '💕', '❤️', '✨', '🌹'];
            $text .= ' ' . $emojis[array_rand($emojis)];
        }
        
        return $text;
    }
    
    /**
     * Generate complete ad data
     */
    public function generateAd($params = []) {
        
        // Required params with defaults
        $category = $params['category'] ?? 'escorts';
        $state_id = $params['state_id'] ?? null;
        $city_id = $params['city_id'] ?? null;
        $city_name = $params['city_name'] ?? 'Delhi';
        $phone = $params['phone'] ?? $this->generateFakePhone();
        $age = $params['age'] ?? rand(21, 32);
        $user_id = $params['user_id'] ?? 1;
        
        // Generate content
        $title = $this->generateTitle($city_name, $category);
        $description = $this->generateDescription($city_name, $age, $phone, $category);
        
        // Prepare ad data
        $adData = [
            'user_id' => $user_id,
            'category_slug' => $category,
            'state_id' => $state_id,
            'city_id' => $city_id,
            'city_slug' => strtolower(str_replace(' ', '-', $city_name)),
            'city_name' => $city_name,
            'title' => $title,
            'slug' => $this->generateSlug($title),
            'description' => $description,
            'age' => $age,
            'phone' => $phone,
            'telegram' => '',
            'whatsapp' => '',
            'status' => 'active',
            'is_featured' => 0,
            'profile_image' => null,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        return $adData;
    }
    
    /**
     * Generate URL-friendly slug
     */
    private function generateSlug($title) {
        $slug = strtolower($title);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim($slug, '-');
        $slug = $slug . '-' . substr(md5(uniqid()), 0, 6);
        return $slug;
    }
    
    /**
     * Generate fake phone number (optional)
     */
    private function generateFakePhone() {
        $prefixes = ['9', '8', '7', '6'];
        $prefix = $prefixes[array_rand($prefixes)];
        $number = $prefix . rand(100000000, 999999999);
        return $number;
    }
    
    /**
     * Batch generate multiple ads
     */
    public function generateBulkAds($count, $params = []) {
        
        $ads = [];
        
        for($i = 0; $i < $count; $i++) {
            
            // Add small delay for randomization
            usleep(1000);
            
            // Generate unique ad
            $ad = $this->generateAd($params);
            
            // Ensure uniqueness
            $ad['title'] = $this->makeUnique($ad['title'], $i);
            
            $ads[] = $ad;
        }
        
        return $ads;
    }
    
    /**
     * Make title unique by adding variation
     */
    private function makeUnique($title, $index) {
        
        // Add small random variation to avoid exact duplicates
        if($index > 0 && rand(1, 3) == 1) {
            $variations = [
                ' - Available Now',
                ' | Call Me',
                ' - Genuine Service',
                ' | VIP',
                ' - Independent'
            ];
            
            if(rand(1, 2) == 1) {
                $title .= $variations[array_rand($variations)];
            }
        }
        
        return $title;
    }
    
    /**
     * Get statistics
     */
    public function getStats() {
        return [
            'total_templates' => $this->conn->query("SELECT COUNT(*) as c FROM content_templates WHERE status='active'")->fetch_assoc()['c'],
            'total_phrases' => $this->conn->query("SELECT COUNT(*) as c FROM phrase_variations WHERE status='active'")->fetch_assoc()['c'],
            'phrase_groups' => count($this->cache),
            'possible_combinations' => $this->calculateCombinations()
        ];
    }
    
    /**
     * Calculate possible unique combinations
     */
    private function calculateCombinations() {
        $combinations = 1;
        foreach($this->cache as $group => $phrases) {
            $unique = count(array_unique($phrases));
            if($unique > 0) {
                $combinations *= $unique;
            }
        }
        return $combinations;
    }
}
