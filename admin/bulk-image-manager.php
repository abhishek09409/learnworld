<?php
session_start();
include '../includes/config.php';

// Check if admin is logged in
if(!isset($_SESSION['user_id'])){
    header("Location: /user/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Bulk Image Manager</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    min-height: 100vh;
    padding: 20px;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
}

.header-box {
    background: rgba(255, 255, 255, 0.95);
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    margin-bottom: 30px;
}

.header-box h1 {
    color: #667eea;
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 10px;
}

.main-card {
    background: rgba(255, 255, 255, 0.95);
    padding: 35px;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

.upload-zone {
    border: 3px dashed #667eea;
    border-radius: 15px;
    padding: 60px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s;
    margin-bottom: 30px;
}

.upload-zone:hover {
    background: rgba(102, 126, 234, 0.05);
    border-color: #764ba2;
}

.upload-zone i {
    font-size: 64px;
    color: #667eea;
    margin-bottom: 20px;
}

.upload-zone h4 {
    color: #333;
    font-weight: 600;
    margin-bottom: 10px;
}

.upload-zone p {
    color: #666;
    font-size: 14px;
}

.image-pool {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 15px;
    margin-top: 30px;
}

.image-item {
    position: relative;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.image-item img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.image-item .delete-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(255, 0, 0, 0.8);
    color: #fff;
    border: none;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    cursor: pointer;
}

.btn-assign {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    border: none;
    padding: 15px 40px;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    width: 100%;
    margin-top: 20px;
}

.stats-box {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.stats-box h6 {
    color: #667eea;
    font-weight: 600;
    margin-bottom: 15px;
}

.stat-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #dee2e6;
}

.stat-item:last-child {
    border-bottom: none;
}

.hide {
    display: none;
}

.progress-box {
    display: none;
    margin-top: 20px;
}

.progress {
    height: 30px;
    border-radius: 10px;
}

.progress-bar {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>
</head>

<body>

<div class="container">
    
    <div class="header-box">
        <h1><i class="fas fa-images"></i> Bulk Image Manager</h1>
        <p>Upload images and assign them to ads automatically</p>
        <a href="bulk-generator.php" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Back to Generator
        </a>
    </div>
    
    <div class="main-card">
        
        <!-- STATS -->
        <div class="stats-box">
            <h6><i class="fas fa-chart-bar"></i> Statistics</h6>
            <div class="stat-item">
                <span>Total Images in Pool:</span>
                <strong id="totalImages">0</strong>
            </div>
            <div class="stat-item">
                <span>Ads without Images:</span>
                <strong id="adsWithoutImages">Loading...</strong>
            </div>
        </div>
        
        <!-- UPLOAD ZONE -->
        <div class="upload-zone" onclick="document.getElementById('imageUpload').click()">
            <i class="fas fa-cloud-upload-alt"></i>
            <h4>Upload Images</h4>
            <p>Click to select multiple images (JPG, PNG, WEBP)</p>
            <p class="text-muted">Recommended: 500x500 to 1000x1000 pixels</p>
        </div>
        
        <input type="file" id="imageUpload" class="hide" multiple accept="image/jpeg,image/png,image/webp">
        
        <!-- PROGRESS -->
        <div class="progress-box" id="uploadProgress">
            <div class="progress">
                <div class="progress-bar" id="progressBar" style="width: 0%">0%</div>
            </div>
        </div>
        
        <!-- IMAGE POOL -->
        <div>
            <h5><i class="fas fa-folder-open"></i> Image Pool</h5>
            <div class="image-pool" id="imagePool">
                <!-- Images will be loaded here -->
            </div>
        </div>
        
        <!-- ASSIGN BUTTON -->
        <button class="btn-assign" onclick="assignImages()">
            <i class="fas fa-magic"></i> Auto-Assign Images to Ads
        </button>
        
        <div id="resultBox" style="margin-top: 20px;"></div>
        
    </div>
    
</div>

<script>
// Load stats and images on page load
window.addEventListener('DOMContentLoaded', function() {
    loadStats();
    loadImages();
});

// Load statistics
function loadStats() {
    fetch('bulk-image-handler.php?action=stats')
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                document.getElementById('totalImages').innerText = data.total_images;
                document.getElementById('adsWithoutImages').innerText = data.ads_without_images;
            }
        });
}

// Load images
function loadImages() {
    fetch('bulk-image-handler.php?action=list')
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                displayImages(data.images);
            }
        });
}

// Display images
function displayImages(images) {
    const pool = document.getElementById('imagePool');
    
    if(images.length === 0) {
        pool.innerHTML = '<p class="text-center text-muted">No images uploaded yet</p>';
        return;
    }
    
    let html = '';
    images.forEach(img => {
        html += `
            <div class="image-item">
                <img src="${img.path}" alt="">
                <button class="delete-btn" onclick="deleteImage('${img.filename}')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
    });
    
    pool.innerHTML = html;
    document.getElementById('totalImages').innerText = images.length;
}

// Handle file upload
document.getElementById('imageUpload').addEventListener('change', function(e) {
    const files = e.target.files;
    
    if(files.length === 0) return;
    
    const formData = new FormData();
    
    for(let i = 0; i < files.length; i++) {
        formData.append('images[]', files[i]);
    }
    
    // Show progress
    document.getElementById('uploadProgress').style.display = 'block';
    
    fetch('bulk-image-handler.php?action=upload', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('uploadProgress').style.display = 'none';
        
        if(data.success) {
            showResult('success', `✅ Uploaded ${data.count} images successfully`);
            loadImages();
            loadStats();
        } else {
            showResult('error', 'Error: ' + data.message);
        }
        
        // Reset input
        e.target.value = '';
    })
    .catch(err => {
        document.getElementById('uploadProgress').style.display = 'none';
        showResult('error', 'Upload failed');
        console.error(err);
    });
});

// Delete image
function deleteImage(filename) {
    if(!confirm('Delete this image?')) return;
    
    fetch('bulk-image-handler.php?action=delete&filename=' + filename)
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                showResult('success', 'Image deleted');
                loadImages();
                loadStats();
            } else {
                showResult('error', 'Error deleting image');
            }
        });
}

// Assign images to ads
function assignImages() {
    if(!confirm('Assign images from pool to ads without images?')) return;
    
    fetch('bulk-image-handler.php?action=assign', {
        method: 'POST'
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            showResult('success', `✅ Assigned images to ${data.assigned_count} ads`);
            loadStats();
        } else {
            showResult('error', 'Error: ' + data.message);
        }
    });
}

// Show result
function showResult(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    document.getElementById('resultBox').innerHTML = `
        <div class="alert ${alertClass}">
            ${message}
        </div>
    `;
    
    setTimeout(() => {
        document.getElementById('resultBox').innerHTML = '';
    }, 5000);
}
</script>

</body>
</html>
