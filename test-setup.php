<?php
/**
 * DIAGNOSTIC TEST - Run this to check setup
 * Access: yourdomain.com/test-setup.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔍 Bulk System Diagnostic Test</h1>";
echo "<style>body{font-family:monospace;padding:20px;} .ok{color:green;} .fail{color:red;}</style>";

$errors = 0;

// Test 1: Config file
echo "<h3>Test 1: Config File</h3>";
if(file_exists(__DIR__ . '/includes/config.php')) {
    echo "✅ <span class='ok'>config.php found</span><br>";
    include __DIR__ . '/includes/config.php';
    if(isset($conn)) {
        echo "✅ <span class='ok'>Database connection exists</span><br>";
    } else {
        echo "❌ <span class='fail'>\$conn variable not defined</span><br>";
        $errors++;
    }
} else {
    echo "❌ <span class='fail'>config.php NOT FOUND</span><br>";
    $errors++;
}

// Test 2: ContentGenerator
echo "<h3>Test 2: ContentGenerator Class</h3>";
if(file_exists(__DIR__ . '/includes/ContentGenerator.php')) {
    echo "✅ <span class='ok'>ContentGenerator.php found</span><br>";
    require_once __DIR__ . '/includes/ContentGenerator.php';
    if(class_exists('ContentGenerator')) {
        echo "✅ <span class='ok'>ContentGenerator class loaded</span><br>";
    } else {
        echo "❌ <span class='fail'>ContentGenerator class not found in file</span><br>";
        $errors++;
    }
} else {
    echo "❌ <span class='fail'>ContentGenerator.php NOT FOUND</span><br>";
    $errors++;
}

// Test 3: Database tables
echo "<h3>Test 3: Database Tables</h3>";
if(isset($conn)) {
    $tables = ['content_templates', 'phrase_variations', 'bulk_batches', 'escorts', 'categories', 'states', 'cities'];
    foreach($tables as $table) {
        $result = $conn->query("SHOW TABLES LIKE '$table'");
        if($result && $result->num_rows > 0) {
            echo "✅ <span class='ok'>Table '$table' exists</span><br>";
        } else {
            echo "❌ <span class='fail'>Table '$table' NOT FOUND</span><br>";
            $errors++;
        }
    }
}

// Test 4: Upload directory
echo "<h3>Test 4: Upload Directory</h3>";
$uploadDir = __DIR__ . '/uploads/bulk-images';
if(file_exists($uploadDir)) {
    echo "✅ <span class='ok'>Upload directory exists</span><br>";
    if(is_writable($uploadDir)) {
        echo "✅ <span class='ok'>Upload directory is writable</span><br>";
    } else {
        echo "❌ <span class='fail'>Upload directory NOT WRITABLE (chmod 777 needed)</span><br>";
        $errors++;
    }
} else {
    echo "⚠️ <span class='fail'>Upload directory doesn't exist (will be auto-created)</span><br>";
}

// Test 5: Admin files
echo "<h3>Test 5: Admin Files</h3>";
$adminFiles = [
    'bulk-generator.php',
    'bulk-process.php',
    'bulk-ads-manager.php',
    'bulk-ads-action.php',
    'bulk-image-manager.php',
    'bulk-image-handler.php'
];
foreach($adminFiles as $file) {
    if(file_exists(__DIR__ . '/admin/' . $file)) {
        echo "✅ <span class='ok'>admin/$file found</span><br>";
    } else {
        echo "❌ <span class='fail'>admin/$file NOT FOUND</span><br>";
        $errors++;
    }
}

// Test 6: Database data
echo "<h3>Test 6: Database Data</h3>";
if(isset($conn)) {
    // Check templates
    $result = $conn->query("SELECT COUNT(*) as count FROM content_templates");
    if($result) {
        $count = $result->fetch_assoc()['count'];
        if($count > 0) {
            echo "✅ <span class='ok'>Templates found: $count</span><br>";
        } else {
            echo "❌ <span class='fail'>No templates in database (run installer)</span><br>";
            $errors++;
        }
    }
    
    // Check phrases
    $result = $conn->query("SELECT COUNT(*) as count FROM phrase_variations");
    if($result) {
        $count = $result->fetch_assoc()['count'];
        if($count > 0) {
            echo "✅ <span class='ok'>Phrases found: $count</span><br>";
        } else {
            echo "❌ <span class='fail'>No phrases in database (run installer)</span><br>";
            $errors++;
        }
    }
}

// Final result
echo "<hr><h2>";
if($errors === 0) {
    echo "🎉 <span class='ok'>ALL TESTS PASSED! System is ready.</span>";
    echo "<br><br><a href='/admin/bulk-generator.php' style='background:#667eea;color:#fff;padding:15px 30px;text-decoration:none;border-radius:8px;'>Start Generating Ads →</a>";
} else {
    echo "❌ <span class='fail'>FOUND $errors ERROR(S). Fix them first.</span>";
    echo "<br><br><a href='/install-bulk-system.php' style='background:#667eea;color:#fff;padding:15px 30px;text-decoration:none;border-radius:8px;'>Run Installer →</a>";
}
echo "</h2>";
?>
