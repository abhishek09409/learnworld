<?php
session_start();
include '../includes/config.php';

// Check if admin is logged in
if(!isset($_SESSION['user_id'])){
    header("Location: /user/login.php");
    exit;
}

// Get filter parameters
$category = $_GET['category'] ?? '';
$state = $_GET['state'] ?? '';
$city = $_GET['city'] ?? '';
$status = $_GET['status'] ?? '';
$batch = $_GET['batch'] ?? '';
$page = intval($_GET['page'] ?? 1);
$perPage = 50;
$offset = ($page - 1) * $perPage;

// Build query
$where = ["user_id = " . $_SESSION['user_id']];

if($category) $where[] = "category_slug = '$category'";
if($state) $where[] = "state_id = $state";
if($city) $where[] = "city_id = $city";
if($status) $where[] = "status = '$status'";

$whereClause = implode(' AND ', $where);

// Get total count
$countQuery = "SELECT COUNT(*) as total FROM escorts WHERE $whereClause";
$countResult = $conn->query($countQuery);
$totalAds = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalAds / $perPage);

// Get ads
$query = "SELECT e.*, c.name as city_name, s.name as state_name, cat.name as category_name 
          FROM escorts e
          LEFT JOIN cities c ON e.city_id = c.id
          LEFT JOIN states s ON e.state_id = s.id
          LEFT JOIN categories cat ON e.category_slug = cat.slug
          WHERE $whereClause
          ORDER BY e.created_at DESC
          LIMIT $offset, $perPage";

$result = $conn->query($query);

// Get statistics
$statsQuery = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status='active' THEN 1 ELSE 0 END) as active,
                SUM(CASE WHEN status='pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN profile_image IS NOT NULL AND profile_image != '' THEN 1 ELSE 0 END) as with_images
                FROM escorts WHERE user_id = {$_SESSION['user_id']}";
$statsResult = $conn->query($statsQuery);
$stats = $statsResult->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title>Bulk Ads Manager</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body {
    background: #f5f6fa;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.top-nav {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 20px 0;
    margin-bottom: 30px;
}

.top-nav h1 {
    font-size: 28px;
    font-weight: 700;
    margin: 0;
}

.nav-buttons {
    display: flex;
    gap: 10px;
}

.nav-buttons a {
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.3s;
}

.nav-buttons a:hover {
    background: rgba(255, 255, 255, 0.3);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-box {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    text-align: center;
}

.stat-box .number {
    font-size: 36px;
    font-weight: 700;
    color: #667eea;
}

.stat-box .label {
    font-size: 14px;
    color: #666;
    margin-top: 5px;
}

.filter-card {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    margin-bottom: 20px;
}

.filter-card h5 {
    margin-bottom: 15px;
    color: #333;
}

.ad-card {
    background: #fff;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    display: flex;
    gap: 15px;
}

.ad-image {
    width: 120px;
    height: 120px;
    border-radius: 8px;
    object-fit: cover;
    background: #e0e0e0;
}

.ad-content {
    flex: 1;
}

.ad-content h6 {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 8px;
    color: #333;
}

.ad-content p {
    font-size: 13px;
    color: #666;
    margin-bottom: 8px;
}

.ad-meta {
    display: flex;
    gap: 15px;
    font-size: 12px;
    color: #888;
}

.ad-meta span {
    display: flex;
    align-items: center;
    gap: 5px;
}

.ad-actions {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.badge-success {
    background: #28a745;
    color: #fff;
}

.badge-warning {
    background: #ffc107;
    color: #333;
}

.btn-sm {
    padding: 6px 12px;
    font-size: 12px;
    border-radius: 6px;
}

.pagination {
    justify-content: center;
    margin-top: 30px;
}

.no-image {
    width: 120px;
    height: 120px;
    border-radius: 8px;
    background: #e0e0e0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #999;
}

.bulk-actions {
    background: #fff;
    padding: 15px;
    border-radius: 12px;
    margin-bottom: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.bulk-actions button {
    margin-right: 10px;
}

@media(max-width: 768px) {
    .ad-card {
        flex-direction: column;
    }
    
    .ad-image, .no-image {
        width: 100%;
        height: 200px;
    }
}
</style>
</head>

<body>

<!-- TOP NAV -->
<div class="top-nav">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1><i class="fas fa-list"></i> Bulk Ads Manager</h1>
            <div class="nav-buttons">
                <a href="bulk-generator.php"><i class="fas fa-plus"></i> Generate New</a>
                <a href="bulk-image-manager.php"><i class="fas fa-images"></i> Images</a>
            </div>
        </div>
    </div>
</div>

<div class="container">
    
    <!-- STATS -->
    <div class="stats-grid">
        <div class="stat-box">
            <div class="number"><?= number_format($stats['total']) ?></div>
            <div class="label">Total Ads</div>
        </div>
        <div class="stat-box">
            <div class="number"><?= number_format($stats['active']) ?></div>
            <div class="label">Active Ads</div>
        </div>
        <div class="stat-box">
            <div class="number"><?= number_format($stats['pending']) ?></div>
            <div class="label">Pending Ads</div>
        </div>
        <div class="stat-box">
            <div class="number"><?= number_format($stats['with_images']) ?></div>
            <div class="label">With Images</div>
        </div>
    </div>
    
    <!-- FILTERS -->
    <div class="filter-card">
        <h5><i class="fas fa-filter"></i> Filters</h5>
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    <?php
                    $cats = $conn->query("SELECT * FROM categories WHERE status='active'");
                    while($cat = $cats->fetch_assoc()){
                        $selected = $category === $cat['slug'] ? 'selected' : '';
                        echo "<option value='{$cat['slug']}' $selected>{$cat['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="state" class="form-select">
                    <option value="">All States</option>
                    <?php
                    $states = $conn->query("SELECT * FROM states");
                    while($st = $states->fetch_assoc()){
                        $selected = $state == $st['id'] ? 'selected' : '';
                        echo "<option value='{$st['id']}' $selected>{$st['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="pending" <?= $status === 'pending' ? 'selected' : '' ?>>Pending</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Apply Filters
                </button>
            </div>
        </form>
    </div>
    
    <!-- BULK ACTIONS -->
    <div class="bulk-actions">
        <div class="d-flex align-items-center gap-2">
            <input type="checkbox" id="selectAll" onclick="toggleSelectAll()">
            <label for="selectAll">Select All</label>
            <button class="btn btn-success btn-sm" onclick="bulkAction('activate')">
                <i class="fas fa-check"></i> Activate Selected
            </button>
            <button class="btn btn-warning btn-sm" onclick="bulkAction('deactivate')">
                <i class="fas fa-ban"></i> Deactivate Selected
            </button>
            <button class="btn btn-danger btn-sm" onclick="bulkAction('delete')">
                <i class="fas fa-trash"></i> Delete Selected
            </button>
            <span id="selectedCount" class="ms-3 text-muted">0 selected</span>
        </div>
    </div>
    
    <!-- ADS LIST -->
    <div id="adsList">
        <?php if($result->num_rows === 0): ?>
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No ads found</h5>
                <a href="bulk-generator.php" class="btn btn-primary mt-3">
                    Generate Your First Ads
                </a>
            </div>
        <?php else: ?>
            <?php while($ad = $result->fetch_assoc()): ?>
                <div class="ad-card">
                    <input type="checkbox" class="ad-checkbox" value="<?= $ad['id'] ?>" 
                           style="margin-right: 10px;" onchange="updateSelectedCount()">
                    
                    <?php if($ad['profile_image']): ?>
                        <img src="<?= $ad['profile_image'] ?>" class="ad-image" alt="">
                    <?php else: ?>
                        <div class="no-image">
                            <i class="fas fa-image fa-2x"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="ad-content">
                        <h6><?= htmlspecialchars($ad['title']) ?></h6>
                        <p><?= htmlspecialchars(substr($ad['description'], 0, 150)) ?>...</p>
                        <div class="ad-meta">
                            <span><i class="fas fa-map-marker-alt"></i> <?= $ad['city_name'] ?>, <?= $ad['state_name'] ?></span>
                            <span><i class="fas fa-tag"></i> <?= $ad['category_name'] ?></span>
                            <span><i class="fas fa-birthday-cake"></i> <?= $ad['age'] ?> years</span>
                            <span><i class="fas fa-phone"></i> <?= $ad['phone'] ?></span>
                            <span><i class="fas fa-clock"></i> <?= date('d M Y', strtotime($ad['created_at'])) ?></span>
                        </div>
                    </div>
                    
                    <div class="ad-actions">
                        <span class="badge <?= $ad['status'] === 'active' ? 'badge-success' : 'badge-warning' ?>">
                            <?= strtoupper($ad['status']) ?>
                        </span>
                        <a href="/ad/<?= $ad['slug'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteAd(<?= $ad['id'] ?>)">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
    
    <!-- PAGINATION -->
    <?php if($totalPages > 1): ?>
        <nav>
            <ul class="pagination">
                <?php for($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&category=<?= $category ?>&state=<?= $state ?>&status=<?= $status ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
    
</div>

<script>
// Toggle select all
function toggleSelectAll() {
    const checkboxes = document.querySelectorAll('.ad-checkbox');
    const selectAll = document.getElementById('selectAll').checked;
    
    checkboxes.forEach(cb => cb.checked = selectAll);
    updateSelectedCount();
}

// Update selected count
function updateSelectedCount() {
    const checked = document.querySelectorAll('.ad-checkbox:checked').length;
    document.getElementById('selectedCount').innerText = checked + ' selected';
}

// Bulk action
function bulkAction(action) {
    const checked = Array.from(document.querySelectorAll('.ad-checkbox:checked')).map(cb => cb.value);
    
    if(checked.length === 0) {
        alert('Please select at least one ad');
        return;
    }
    
    let confirmMsg = '';
    if(action === 'delete') confirmMsg = `Delete ${checked.length} ads? This cannot be undone.`;
    else if(action === 'activate') confirmMsg = `Activate ${checked.length} ads?`;
    else if(action === 'deactivate') confirmMsg = `Deactivate ${checked.length} ads?`;
    
    if(!confirm(confirmMsg)) return;
    
    // Send request
    fetch('bulk-ads-action.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            action: action,
            ids: checked
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            alert(`✅ ${data.message}`);
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    });
}

// Delete single ad
function deleteAd(id) {
    if(!confirm('Delete this ad?')) return;
    
    fetch('bulk-ads-action.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            action: 'delete',
            ids: [id]
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            alert('✅ Ad deleted');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    });
}
</script>

</body>
</html>
