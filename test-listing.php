<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'includes/config.php';

echo "<h2>🔍 LIVE DEBUG - Step by Step</h2>";
echo "<hr>";

// STEP 1: Connection check
echo "<h3>Step 1: Database Connection</h3>";
if($conn){
    echo "<p style='color:green;'>✅ Connected to database</p>";
} else {
    echo "<p style='color:red;'>❌ Connection failed!</p>";
    die();
}

// STEP 2: Count total records
echo "<h3>Step 2: Total Records in escorts table</h3>";
$count = $conn->query("SELECT COUNT(*) as total FROM escorts");
$total = $count->fetch_assoc()['total'];
echo "<p><strong>Total records:</strong> $total</p>";

// STEP 3: Count active records
echo "<h3>Step 3: Active Records</h3>";
$active = $conn->query("SELECT COUNT(*) as total FROM escorts WHERE status='active'");
$active_total = $active->fetch_assoc()['total'];
echo "<p><strong>Active records:</strong> $active_total</p>";

if($active_total == 0){
    echo "<p style='color:red;'>❌ PROBLEM: No active records found!</p>";
    echo "<p>Check your database - all records might have status='inactive' or NULL</p>";
    
    // Show actual status values
    echo "<h4>Let's check what status values exist:</h4>";
    $status_check = $conn->query("SELECT status, COUNT(*) as count FROM escorts GROUP BY status");
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Status</th><th>Count</th></tr>";
    while($s = $status_check->fetch_assoc()){
        $status_display = $s['status'] ? $s['status'] : '(NULL)';
        echo "<tr><td>$status_display</td><td>{$s['count']}</td></tr>";
    }
    echo "</table>";
    die();
}

// STEP 4: Try actual query
echo "<h3>Step 4: Running Query</h3>";
$sql = "SELECT * FROM escorts WHERE status='active' ORDER BY id DESC LIMIT 5";
echo "<p><code>$sql</code></p>";

$result = $conn->query($sql);

if(!$result){
    echo "<p style='color:red;'>❌ Query failed: " . $conn->error . "</p>";
    die();
}

echo "<p style='color:green;'>✅ Query executed successfully</p>";
echo "<p><strong>Rows returned:</strong> " . $result->num_rows . "</p>";

if($result->num_rows == 0){
    echo "<p style='color:red;'>❌ Query returned 0 rows but we know active records exist!</p>";
    die();
}

// STEP 5: Display results
echo "<h3>Step 5: Sample Data (First 5 records)</h3>";
echo "<table border='1' cellpadding='10' style='border-collapse:collapse; width:100%;'>";
echo "<tr>";
echo "<th>ID</th>";
echo "<th>Title</th>";
echo "<th>Category</th>";
echo "<th>City</th>";
echo "<th>Status</th>";
echo "<th>Phone</th>";
echo "</tr>";

while($row = $result->fetch_assoc()){
    echo "<tr>";
    echo "<td>{$row['id']}</td>";
    echo "<td>" . substr($row['title'], 0, 50) . "...</td>";
    echo "<td>{$row['category_slug']}</td>";
    echo "<td>{$row['city_slug']}</td>";
    echo "<td>{$row['status']}</td>";
    echo "<td>{$row['phone']}</td>";
    echo "</tr>";
}

echo "</table>";

echo "<hr>";
echo "<h3>✅ ALL TESTS PASSED!</h3>";
echo "<p>Data exists and query works. If listing.php is still blank, the problem is:</p>";
echo "<ul>";
echo "<li>1. header.php or footer.php has an error and stops execution</li>";
echo "<li>2. Some other PHP error is happening</li>";
echo "<li>3. Browser cache issue</li>";
echo "</ul>";

echo "<h4>Next Steps:</h4>";
echo "<p>1. Clear browser cache (Ctrl + Shift + Delete)</p>";
echo "<p>2. Try listing.php again</p>";
echo "<p>3. Check browser console for JavaScript errors (F12)</p>";
echo "<p>4. View page source (Ctrl + U) and see if HTML is being generated</p>";
?>
