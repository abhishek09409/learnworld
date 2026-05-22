<?php
include 'includes/config.php';

echo "<h2>🔍 Debug Report</h2>";

// CHECK 1: escorts table data
echo "<h3>1️⃣ Check: escorts Table Data</h3>";
$result = $conn->query("SELECT COUNT(*) as total FROM escorts");
$count = $result->fetch_assoc()['total'];
echo "<p><strong>Total Records in escorts table:</strong> $count</p>";

if($count > 0){
    echo "<p style='color:green;'>✅ Data exists in escorts table</p>";
    
    // Show first 5 records
    echo "<h4>First 5 Records:</h4>";
    $records = $conn->query("SELECT id, title, category_slug, city_slug, status FROM escorts LIMIT 5");
    
    echo "<table border='1' cellpadding='10' style='border-collapse:collapse;'>";
    echo "<tr><th>ID</th><th>Title</th><th>Category</th><th>City</th><th>Status</th></tr>";
    
    while($row = $records->fetch_assoc()){
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['title']}</td>";
        echo "<td>{$row['category_slug']}</td>";
        echo "<td>{$row['city_slug']}</td>";
        echo "<td>{$row['status']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
} else {
    echo "<p style='color:red;'>❌ No data in escorts table!</p>";
}

// CHECK 2: Active records
echo "<h3>2️⃣ Check: Active Status Records</h3>";
$active = $conn->query("SELECT COUNT(*) as total FROM escorts WHERE status='active'");
$active_count = $active->fetch_assoc()['total'];
echo "<p><strong>Active Records:</strong> $active_count</p>";

if($active_count > 0){
    echo "<p style='color:green;'>✅ Active records found</p>";
} else {
    echo "<p style='color:red;'>❌ No active records! All records have status='inactive' or NULL</p>";
}

// CHECK 3: categories table
echo "<h3>3️⃣ Check: Categories Table</h3>";
$cats = $conn->query("SELECT COUNT(*) as total FROM categories WHERE status='active'");
$cat_count = $cats->fetch_assoc()['total'];
echo "<p><strong>Active Categories:</strong> $cat_count</p>";

if($cat_count > 0){
    echo "<p style='color:green;'>✅ Categories exist</p>";
    
    $cat_list = $conn->query("SELECT name, slug FROM categories WHERE status='active' LIMIT 5");
    echo "<p><strong>Categories:</strong> ";
    $cats_arr = [];
    while($c = $cat_list->fetch_assoc()){
        $cats_arr[] = $c['name'] . " ({$c['slug']})";
    }
    echo implode(", ", $cats_arr);
    echo "</p>";
} else {
    echo "<p style='color:red;'>❌ No active categories!</p>";
}

// CHECK 4: states and cities
echo "<h3>4️⃣ Check: States & Cities</h3>";
$states = $conn->query("SELECT COUNT(*) as total FROM states WHERE status='active'");
$state_count = $states->fetch_assoc()['total'];
echo "<p><strong>Active States:</strong> $state_count</p>";

$cities = $conn->query("SELECT COUNT(*) as total FROM cities WHERE status='active'");
$city_count = $cities->fetch_assoc()['total'];
echo "<p><strong>Active Cities:</strong> $city_count</p>";

// CHECK 5: Test query that listing.php uses
echo "<h3>5️⃣ Check: Actual Listing Query Test</h3>";
$test_sql = "SELECT * FROM escorts WHERE status='active' ORDER BY id DESC LIMIT 20";
$test_result = $conn->query($test_sql);

echo "<p><strong>Query:</strong> <code>$test_sql</code></p>";
echo "<p><strong>Results Found:</strong> {$test_result->num_rows}</p>";

if($test_result->num_rows > 0){
    echo "<p style='color:green;'>✅ Query returns results - listing.php SHOULD show data</p>";
    
    echo "<h4>Sample Results:</h4>";
    echo "<table border='1' cellpadding='10' style='border-collapse:collapse;'>";
    echo "<tr><th>ID</th><th>Title (First 50 chars)</th><th>Category</th><th>City</th></tr>";
    
    while($row = $test_result->fetch_assoc()){
        $short_title = substr($row['title'], 0, 50) . '...';
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$short_title}</td>";
        echo "<td>{$row['category_slug']}</td>";
        echo "<td>{$row['city_slug']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
} else {
    echo "<p style='color:red;'>❌ Query returns no results!</p>";
}

// CHECK 6: includes/config.php exists?
echo "<h3>6️⃣ Check: Config File</h3>";
if(file_exists('includes/config.php')){
    echo "<p style='color:green;'>✅ includes/config.php exists</p>";
} else {
    echo "<p style='color:red;'>❌ includes/config.php NOT FOUND!</p>";
}

// CHECK 7: header.php and footer.php
echo "<h3>7️⃣ Check: Template Files</h3>";
if(file_exists('header.php')){
    echo "<p style='color:green;'>✅ header.php exists</p>";
} else {
    echo "<p style='color:red;'>❌ header.php NOT FOUND!</p>";
}

if(file_exists('footer.php')){
    echo "<p style='color:green;'>✅ footer.php exists</p>";
} else {
    echo "<p style='color:red;'>❌ footer.php NOT FOUND!</p>";
}

echo "<hr>";
echo "<h3>🎯 Summary</h3>";
echo "<p>If all checks show ✅, then listing.php should work.</p>";
echo "<p>If you see ❌, that's the problem to fix.</p>";
?>
