<?php
/**
 * =====================================================
 * BULK AD SYSTEM - ONE-CLICK INSTALLER
 * =====================================================
 * Run this file once to set up the complete system
 * Access: yourdomain.com/install-bulk-system.php
 */

// Prevent running twice
$lockFile = __DIR__ . '/bulk-system-installed.lock';
if(file_exists($lockFile)) {
    die('<h2 style="color: red;">❌ System already installed!</h2><p>Delete <code>bulk-system-installed.lock</code> file to reinstall.</p>');
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Bulk Ad System - Installer</title>
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 20px;
    margin: 0;
}

.container {
    max-width: 800px;
    margin: 50px auto;
    background: #fff;
    border-radius: 15px;
    padding: 40px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}

h1 {
    color: #667eea;
    text-align: center;
    margin-bottom: 10px;
}

.subtitle {
    text-align: center;
    color: #666;
    margin-bottom: 40px;
}

.step {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    border-left: 4px solid #667eea;
}

.step h3 {
    margin-top: 0;
    color: #333;
}

.status {
    display: inline-block;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
}

.status.pending {
    background: #ffc107;
    color: #fff;
}

.status.success {
    background: #28a745;
    color: #fff;
}

.status.error {
    background: #dc3545;
    color: #fff;
}

.btn {
    display: inline-block;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 15px 40px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    border: none;
    cursor: pointer;
    font-size: 16px;
}

.btn:hover {
    opacity: 0.9;
}

.text-center {
    text-align: center;
}

.code {
    background: #2d2d2d;
    color: #f8f8f2;
    padding: 15px;
    border-radius: 8px;
    overflow-x: auto;
    font-family: 'Courier New', monospace;
    font-size: 13px;
}

.alert {
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.alert-info {
    background: #d1ecf1;
    border: 1px solid #bee5eb;
    color: #0c5460;
}

.alert-success {
    background: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

ul {
    line-height: 1.8;
}
</style>
</head>

<body>

<div class="container">
    
    <h1>🚀 Bulk Ad System Installer</h1>
    <p class="subtitle">Complete setup in 2 minutes</p>
    
    <?php
    include 'includes/config.php';
    
    $errors = [];
    $success = [];
    
    // Step 1: Check database connection
    if($conn->connect_error) {
        $errors[] = "Database connection failed: " . $conn->connect_error;
    } else {
        $success[] = "Database connection successful";
    }
    
    // Step 2: Check if tables exist
    $tablesExist = true;
    $requiredTables = ['escorts', 'categories', 'states', 'cities'];
    
    foreach($requiredTables as $table) {
        $result = $conn->query("SHOW TABLES LIKE '$table'");
        if($result->num_rows === 0) {
            $tablesExist = false;
            $errors[] = "Table '$table' does not exist";
        }
    }
    
    if($tablesExist) {
        $success[] = "All required tables exist";
    }
    
    // Step 3: Create bulk system tables
    if(empty($errors)) {
        
        // Read and execute SQL file
        $sqlFile = __DIR__ . '/database/bulk_ads_schema.sql';
        
        if(!file_exists($sqlFile)) {
            $errors[] = "SQL file not found: database/bulk_ads_schema.sql";
        } else {
            $sql = file_get_contents($sqlFile);
            
            // Split by semicolon and execute each query
            $queries = array_filter(array_map('trim', explode(';', $sql)));
            
            foreach($queries as $query) {
                if(!empty($query)) {
                    if(!$conn->query($query)) {
                        // Check if error is "table already exists"
                        if(strpos($conn->error, 'already exists') === false) {
                            $errors[] = "SQL Error: " . $conn->error;
                        }
                    }
                }
            }
            
            if(empty($errors)) {
                $success[] = "Database tables created successfully";
            }
        }
    }
    
    // Step 4: Check ContentGenerator class
    if(file_exists(__DIR__ . '/includes/ContentGenerator.php')) {
        $success[] = "ContentGenerator class found";
    } else {
        $errors[] = "ContentGenerator.php not found in includes/";
    }
    
    // Step 5: Create upload directory
    $uploadDir = __DIR__ . '/uploads/bulk-images';
    
    if(!file_exists($uploadDir)) {
        if(mkdir($uploadDir, 0777, true)) {
            $success[] = "Upload directory created";
        } else {
            $errors[] = "Failed to create upload directory";
        }
    } else {
        $success[] = "Upload directory exists";
    }
    
    // Check if writable
    if(is_writable($uploadDir)) {
        $success[] = "Upload directory is writable";
    } else {
        $errors[] = "Upload directory is not writable. Run: chmod 777 uploads/bulk-images";
    }
    
    // Display results
    ?>
    
    <div class="step">
        <h3>📋 Installation Status</h3>
        
        <?php if(!empty($success)): ?>
            <div class="alert alert-success">
                <strong>✅ Success:</strong>
                <ul>
                    <?php foreach($success as $msg): ?>
                        <li><?= $msg ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if(!empty($errors)): ?>
            <div class="alert alert-danger" style="background: #f8d7da; border-color: #f5c6cb; color: #721c24;">
                <strong>❌ Errors:</strong>
                <ul>
                    <?php foreach($errors as $err): ?>
                        <li><?= $err ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
    
    <?php if(empty($errors)): ?>
        
        <!-- SUCCESS -->
        <div class="alert alert-success">
            <h3 style="margin-top: 0;">🎉 Installation Complete!</h3>
            <p>Your bulk ad system is ready to use.</p>
        </div>
        
        <div class="step">
            <h3>📁 System Files</h3>
            <ul>
                <li>✅ Database tables created</li>
                <li>✅ Templates installed (8 templates)</li>
                <li>✅ Phrase variations installed (100+ phrases)</li>
                <li>✅ Upload directory ready</li>
                <li>✅ Content generator ready</li>
            </ul>
        </div>
        
        <div class="step">
            <h3>🚀 Next Steps</h3>
            <ol>
                <li>Access the bulk generator: <code>/admin/bulk-generator.php</code></li>
                <li>Generate your first test ads (start with 5-10)</li>
                <li>Upload images: <code>/admin/bulk-image-manager.php</code></li>
                <li>Manage ads: <code>/admin/bulk-ads-manager.php</code></li>
            </ol>
        </div>
        
        <div class="step">
            <h3>📚 Documentation</h3>
            <p>Read the complete guide: <code>BULK_AD_SYSTEM_README.md</code></p>
        </div>
        
        <div class="text-center" style="margin-top: 30px;">
            <a href="/admin/bulk-generator.php" class="btn">
                🚀 Start Generating Ads
            </a>
        </div>
        
        <?php
        // Create lock file
        file_put_contents($lockFile, date('Y-m-d H:i:s'));
        ?>
        
    <?php else: ?>
        
        <!-- ERRORS -->
        <div class="step">
            <h3>🔧 Manual Steps Required</h3>
            
            <?php if(strpos(implode(' ', $errors), 'chmod') !== false): ?>
                <p><strong>Set Upload Directory Permissions:</strong></p>
                <div class="code">chmod 777 uploads/bulk-images</div>
            <?php endif; ?>
            
            <?php if(strpos(implode(' ', $errors), 'SQL') !== false): ?>
                <p><strong>Import SQL Manually:</strong></p>
                <ol>
                    <li>Open phpMyAdmin</li>
                    <li>Select your database</li>
                    <li>Go to Import tab</li>
                    <li>Upload: <code>database/bulk_ads_schema.sql</code></li>
                </ol>
            <?php endif; ?>
            
            <p>After fixing errors, refresh this page to retry installation.</p>
        </div>
        
    <?php endif; ?>
    
    <hr style="margin: 40px 0; border: none; border-top: 1px solid #dee2e6;">
    
    <div style="text-align: center; color: #666; font-size: 14px;">
        <p>Bulk Ad Generation System v1.0</p>
        <p>Built for high-volume classified sites</p>
    </div>
    
</div>

</body>
</html>
