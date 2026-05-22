<?php
include '../includes/config.php';

echo "<h2>🖼️ Bulk Image Updater</h2>";
echo "<hr>";

// Check if uploads directory exists
$upload_dir = '../uploads';
if(!is_dir($upload_dir)){
    mkdir($upload_dir, 0755, true);
    echo "<p>✅ Created uploads directory</p>";
}

// Unsplash random portrait images (free to use)
$image_urls = [
    'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400',
    'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=400',
    'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?w=400',
    'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=400',
    'https://images.unsplash.com/photo-1488426862026-3ee34a7d66df?w=400',
    'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400',
    'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=400',
    'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?w=400',
    'https://images.unsplash.com/photo-1496440737103-cd596325d314?w=400',
    'https://images.unsplash.com/photo-1521146764736-56c929d59c83?w=400',
];

echo "<h3>Step 1: Downloading Sample Images...</h3>";

$downloaded_images = [];

foreach($image_urls as $index => $url){
    $image_name = 'escort_' . ($index + 1) . '.jpg';
    $save_path = $upload_dir . '/' . $image_name;
    
    // Download image
    $image_data = @file_get_contents($url);
    
    if($image_data){
        file_put_contents($save_path, $image_data);
        $downloaded_images[] = $image_name;
        echo "<p>✅ Downloaded: $image_name</p>";
    } else {
        echo "<p>❌ Failed to download image " . ($index + 1) . "</p>";
    }
}

echo "<p><strong>Total Downloaded:</strong> " . count($downloaded_images) . " images</p>";

echo "<hr>";
echo "<h3>Step 2: Updating Escort Records...</h3>";

// Get all escorts without images
$result = $conn->query("SELECT id, title FROM escorts WHERE profile_image IS NULL OR profile_image = '' OR profile_image = 'default.jpg' LIMIT 100");

$updated = 0;

while($row = $result->fetch_assoc()){
    // Pick random image from downloaded
    $random_image = $downloaded_images[array_rand($downloaded_images)];
    
    $update = $conn->prepare("UPDATE escorts SET profile_image = ? WHERE id = ?");
    $update->bind_param("si", $random_image, $row['id']);
    
    if($update->execute()){
        $updated++;
        echo "<p>✅ Updated ID {$row['id']}: {$row['title']}</p>";
    }
}

echo "<hr>";
echo "<h3>✅ Summary</h3>";
echo "<p><strong>Images Downloaded:</strong> " . count($downloaded_images) . "</p>";
echo "<p><strong>Records Updated:</strong> $updated</p>";
echo "<p><strong>Location:</strong> /uploads/</p>";

echo "<hr>";
echo "<h3>🎯 Next Steps:</h3>";
echo "<ol>";
echo "<li>Go to your listing page: <a href='/listing-standalone.php'>listing-standalone.php</a></li>";
echo "<li>All ads will now show images!</li>";
echo "</ol>";
?>
