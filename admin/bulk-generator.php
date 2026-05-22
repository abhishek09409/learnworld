<?php
session_start();
include '../includes/config.php';

// Check if admin is logged in
if(!isset($_SESSION['user_id'])){
    header("Location: /user/login.php");
    exit;
}

// Load ContentGenerator
require_once '../includes/ContentGenerator.php';
$generator = new ContentGenerator($conn);
$stats = $generator->getStats();
?>

<!DOCTYPE html>
<html>
<head>
<title>Bulk Ad Generator - Admin Panel</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

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

.header-box p {
    color: #666;
    font-size: 15px;
}

.stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.stat-card .icon {
    font-size: 40px;
    color: #667eea;
    margin-bottom: 10px;
}

.stat-card .number {
    font-size: 36px;
    font-weight: 700;
    color: #333;
    margin-bottom: 5px;
}

.stat-card .label {
    font-size: 14px;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.main-card {
    background: rgba(255, 255, 255, 0.95);
    padding: 35px;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

.form-section {
    margin-bottom: 30px;
}

.form-section h5 {
    color: #667eea;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e0e0e0;
}

.form-control, .form-select {
    height: 50px;
    border-radius: 10px;
    border: 2px solid #e0e0e0;
    padding: 0 15px;
    font-size: 15px;
    transition: all 0.3s;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-generate {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    border: none;
    padding: 15px 40px;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    width: 100%;
    margin-top: 20px;
}

.btn-generate:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
}

.btn-generate:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.preview-box {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    margin-top: 20px;
    display: none;
}

.preview-item {
    background: #fff;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 10px;
    border-left: 4px solid #667eea;
}

.preview-item h6 {
    color: #667eea;
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 8px;
}

.preview-item p {
    color: #666;
    font-size: 13px;
    margin-bottom: 5px;
}

.progress-box {
    display: none;
    margin-top: 20px;
}

.progress {
    height: 30px;
    border-radius: 10px;
    overflow: hidden;
}

.progress-bar {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    font-weight: 600;
}

.alert {
    border-radius: 10px;
    padding: 15px 20px;
}

.info-box {
    background: #fff3cd;
    border: 1px solid #ffc107;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.info-box i {
    color: #ff6b6b;
    margin-right: 8px;
}

.phone-options {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}

.phone-option {
    flex: 1;
    padding: 15px;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    cursor: pointer;
    text-align: center;
    transition: all 0.3s;
}

.phone-option:hover {
    border-color: #667eea;
}

.phone-option.active {
    border-color: #667eea;
    background: rgba(102, 126, 234, 0.1);
}

.phone-option i {
    font-size: 24px;
    color: #667eea;
    margin-bottom: 8px;
}

.phone-option h6 {
    font-size: 14px;
    margin: 0;
}

.hide {
    display: none;
}

@media(max-width: 768px) {
    .stats-row {
        grid-template-columns: 1fr;
    }
    
    .header-box h1 {
        font-size: 24px;
    }
}
</style>
</head>

<body>

<div class="container">
    
    <!-- HEADER -->
    <div class="header-box">
        <h1><i class="fas fa-rocket"></i> Bulk Ad Generator</h1>
        <p>Generate hundreds of unique, humanized ads instantly with AI-powered templates</p>
    </div>
    
    <!-- STATS -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="icon"><i class="fas fa-file-alt"></i></div>
            <div class="number"><?= number_format($stats['total_templates']) ?></div>
            <div class="label">Templates</div>
        </div>
        
        <div class="stat-card">
            <div class="icon"><i class="fas fa-comments"></i></div>
            <div class="number"><?= number_format($stats['total_phrases']) ?></div>
            <div class="label">Phrase Variations</div>
        </div>
        
        <div class="stat-card">
            <div class="icon"><i class="fas fa-magic"></i></div>
            <div class="number"><?= $stats['phrase_groups'] ?></div>
            <div class="label">Content Groups</div>
        </div>
        
        <div class="stat-card">
            <div class="icon"><i class="fas fa-infinity"></i></div>
            <div class="number"><?= number_format($stats['possible_combinations']) ?></div>
            <div class="label">Combinations</div>
        </div>
    </div>
    
    <!-- MAIN FORM -->
    <div class="main-card">
        
        <form id="bulkForm">
            
            <!-- BASIC SETTINGS -->
            <div class="form-section">
                <h5><i class="fas fa-cog"></i> Basic Settings</h5>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Number of Ads</label>
                        <input type="number" name="count" id="adCount" class="form-control" 
                               min="1" max="1000" value="10" required>
                        <small class="text-muted">Max: 1000 ads per batch</small>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" id="category" class="form-select" required>
                            <option value="">Select Category</option>
                            <?php
                            $cats = $conn->query("SELECT * FROM categories WHERE status='active' ORDER BY name");
                            while($cat = $cats->fetch_assoc()){
                                echo "<option value='{$cat['slug']}'>{$cat['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">State</label>
                        <select name="state" id="state" class="form-select" required>
                            <option value="">Select State</option>
                            <?php
                            $states = $conn->query("SELECT * FROM states ORDER BY name");
                            while($state = $states->fetch_assoc()){
                                echo "<option value='{$state['id']}'>{$state['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">City</label>
                        <select name="city" id="city" class="form-select" required>
                            <option value="">Select State First</option>
                        </select>
                        <small class="text-muted" id="cityDebug"></small>
                    </div>
                </div>
            </div>
            
            <!-- CONTACT SETTINGS -->
            <div class="form-section">
                <h5><i class="fas fa-phone"></i> Contact Settings</h5>
                
                <div class="phone-options">
                    <div class="phone-option active" onclick="selectPhoneOption('single')">
                        <i class="fas fa-mobile-alt"></i>
                        <h6>Single Number</h6>
                        <small>All ads use one number</small>
                    </div>
                    
                    <div class="phone-option" onclick="selectPhoneOption('random')">
                        <i class="fas fa-random"></i>
                        <h6>Random Numbers</h6>
                        <small>Auto-generate unique numbers</small>
                    </div>
                    
                    <div class="phone-option" onclick="selectPhoneOption('list')">
                        <i class="fas fa-list"></i>
                        <h6>Number List</h6>
                        <small>Provide multiple numbers</small>
                    </div>
                </div>
                
                <input type="hidden" name="phone_mode" id="phoneMode" value="single">
                
                <div id="singlePhoneBox">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone_single" class="form-control" 
                           placeholder="9876543210" pattern="[0-9]{10}">
                    <small class="text-muted">10 digit number</small>
                </div>
                
                <div id="phoneListBox" class="hide">
                    <label class="form-label">Phone Numbers (One per line)</label>
                    <textarea name="phone_list" class="form-control" rows="5" 
                              placeholder="9876543210&#10;9876543211&#10;9876543212"></textarea>
                    <small class="text-muted">Numbers will be rotated for ads</small>
                </div>
                
                <div id="randomPhoneBox" class="hide">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Random 10-digit numbers will be generated automatically for each ad
                    </div>
                </div>
            </div>
            
            <!-- AGE SETTINGS -->
            <div class="form-section">
                <h5><i class="fas fa-user"></i> Age Settings</h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Minimum Age</label>
                        <input type="number" name="age_min" class="form-control" 
                               min="18" max="50" value="21" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Maximum Age</label>
                        <input type="number" name="age_max" class="form-control" 
                               min="18" max="50" value="32" required>
                    </div>
                </div>
                
                <small class="text-muted">Random ages will be selected between min and max</small>
            </div>
            
            <!-- ADVANCED OPTIONS -->
            <div class="form-section">
                <h5><i class="fas fa-sliders-h"></i> Advanced Options</h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="autoPublish" name="auto_publish" checked>
                            <label class="form-check-label" for="autoPublish">
                                Auto-publish ads (Set as active)
                            </label>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="addDelay" name="add_delay">
                            <label class="form-check-label" for="addDelay">
                                Add random delays (More natural)
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- INFO BOX -->
            <div class="info-box">
                <i class="fas fa-lightbulb"></i>
                <strong>Pro Tip:</strong> For best results, use "Add random delays" option to make ads appear more natural and avoid spam detection.
            </div>
            
            <!-- BUTTONS -->
            <div class="row">
                <div class="col-md-6">
                    <button type="button" onclick="previewAds()" class="btn btn-outline-primary w-100">
                        <i class="fas fa-eye"></i> Preview Samples
                    </button>
                </div>
                
                <div class="col-md-6">
                    <button type="submit" class="btn-generate">
                        <i class="fas fa-rocket"></i> Generate Ads Now
                    </button>
                </div>
            </div>
            
        </form>
        
        <!-- PROGRESS BAR -->
        <div class="progress-box" id="progressBox">
            <h6>Generating Ads...</h6>
            <div class="progress">
                <div class="progress-bar" role="progressbar" id="progressBar" style="width: 0%">0%</div>
            </div>
            <p class="text-center mt-2" id="progressText">Starting...</p>
        </div>
        
        <!-- PREVIEW BOX -->
        <div class="preview-box" id="previewBox">
            <h5><i class="fas fa-eye"></i> Sample Preview (First 3 Ads)</h5>
            <div id="previewContent"></div>
        </div>
        
        <!-- RESULT BOX -->
        <div id="resultBox" style="margin-top: 20px;"></div>
        
    </div>
    
</div>

<script>
// Phone option selection
function selectPhoneOption(mode) {
    document.querySelectorAll('.phone-option').forEach(el => el.classList.remove('active'));
    event.target.closest('.phone-option').classList.add('active');
    
    document.getElementById('phoneMode').value = mode;
    
    document.getElementById('singlePhoneBox').classList.add('hide');
    document.getElementById('phoneListBox').classList.add('hide');
    document.getElementById('randomPhoneBox').classList.add('hide');
    
    if(mode === 'single') {
        document.getElementById('singlePhoneBox').classList.remove('hide');
    } else if(mode === 'list') {
        document.getElementById('phoneListBox').classList.remove('hide');
    } else if(mode === 'random') {
        document.getElementById('randomPhoneBox').classList.remove('hide');
    }
}

// Load cities based on state
document.getElementById('state').addEventListener('change', function() {
    const stateId = this.value;
    
    if(!stateId) {
        document.getElementById('city').innerHTML = '<option value="">Select State First</option>';
        return;
    }
    
    document.getElementById('city').innerHTML = '<option value="">Loading...</option>';
    
    fetch('/get-cities.php?state_id=' + stateId)
        .then(res => res.text())
        .then(data => {
            document.getElementById('city').innerHTML = data;
            // Debug: Show loaded options count
            const optCount = document.getElementById('city').options.length;
            document.getElementById('cityDebug').innerText = optCount + ' cities loaded';
            console.log('Cities HTML:', data);
        })
        .catch(err => {
            console.error('Error loading cities:', err);
            document.getElementById('city').innerHTML = '<option value="">Error loading cities</option>';
        });
});

// Also listen for city change to debug
document.getElementById('city').addEventListener('change', function() {
    console.log('City selected - value:', this.value, 'text:', this.options[this.selectedIndex].text);
    document.getElementById('cityDebug').innerText = 'Selected: ' + this.value;
});

// Preview ads
function previewAds() {
    const formData = new FormData(document.getElementById('bulkForm'));
    
    const category = formData.get('category');
    const state = formData.get('state');
    const city = formData.get('city');
    
    // Debug - check values
    console.log('Form Values:', {category, state, city});
    
    // Validation
    if(!category || !state || !city) {
        alert('Please fill all required fields.\n\nCategory: ' + (category || 'EMPTY') + '\nState: ' + (state || 'EMPTY') + '\nCity: ' + (city || 'EMPTY'));
        return;
    }
    
    // Show loading
    document.getElementById('previewBox').style.display = 'block';
    document.getElementById('previewContent').innerHTML = '<p class="text-center"><i class="fas fa-spinner fa-spin"></i> Generating preview...</p>';
    
    // Request preview
    formData.append('action', 'preview');
    
    fetch('bulk-process.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            displayPreview(data.ads);
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(err => {
        alert('Error generating preview');
        console.error(err);
    });
}

// Display preview
function displayPreview(ads) {
    let html = '';
    
    ads.forEach((ad, index) => {
        html += `
            <div class="preview-item">
                <h6>${index + 1}. ${ad.title}</h6>
                <p><strong>Description:</strong> ${ad.description.substring(0, 150)}...</p>
                <p><strong>Age:</strong> ${ad.age} | <strong>Phone:</strong> ${ad.phone}</p>
            </div>
        `;
    });
    
    document.getElementById('previewContent').innerHTML = html;
}

// Form submission
document.getElementById('bulkForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const count = parseInt(formData.get('count'));
    
    const category = formData.get('category');
    const state = formData.get('state');
    const city = formData.get('city');
    
    // Debug log
    console.log('Submit Values:', {category, state, city, count});
    
    // Validation
    if(!category || !state || !city) {
        alert('Please fill all required fields.\n\nCategory: ' + (category || 'EMPTY') + '\nState: ' + (state || 'EMPTY') + '\nCity: ' + (city || 'EMPTY'));
        return;
    }
    
    if(count < 1 || count > 1000) {
        alert('Number of ads must be between 1 and 1000');
        return;
    }
    
    // Confirm
    if(!confirm(`Generate ${count} ads? This action cannot be undone.`)) {
        return;
    }
    
    // Disable form
    document.querySelector('.btn-generate').disabled = true;
    document.getElementById('progressBox').style.display = 'block';
    document.getElementById('previewBox').style.display = 'none';
    
    // Start generation
    formData.append('action', 'generate');
    
    fetch('bulk-process.php', {
        method: 'POST',
        body: formData
    })
    .then(res => {
        console.log('Response status:', res.status);
        return res.text();
    })
    .then(text => {
        console.log('Raw response:', text);
        try {
            const data = JSON.parse(text);
            document.querySelector('.btn-generate').disabled = false;
            document.getElementById('progressBox').style.display = 'none';
            
            if(data.success) {
                showResult('success', `🎉 Successfully generated ${data.count} ads!`);
                
                // Reset form
                setTimeout(() => {
                    location.reload();
                }, 3000);
            } else {
                showResult('error', 'Error: ' + data.message);
            }
        } catch(parseErr) {
            document.querySelector('.btn-generate').disabled = false;
            document.getElementById('progressBox').style.display = 'none';
            showResult('error', 'Server Error: ' + text.substring(0, 200));
            console.error('Parse error:', parseErr, 'Raw:', text);
        }
    })
    .catch(err => {
        document.querySelector('.btn-generate').disabled = false;
        document.getElementById('progressBox').style.display = 'none';
        showResult('error', 'Network Error: ' + err.message);
        console.error(err);
    });
});

// Show result
function showResult(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    document.getElementById('resultBox').innerHTML = `
        <div class="alert ${alertClass}">
            ${message}
        </div>
    `;
}

// Update progress (can be called via AJAX polling)
function updateProgress(percent, text) {
    document.getElementById('progressBar').style.width = percent + '%';
    document.getElementById('progressBar').innerText = percent + '%';
    document.getElementById('progressText').innerText = text;
}
</script>

</body>
</html>
