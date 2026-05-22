<?php
include 'includes/config.php';

// Debug mode - remove after testing
ini_set('display_errors', 1);
error_reporting(E_ALL);

/* ================= CLEAN URL ================= */

// Get from URL query parameters instead of path
$category = $_GET['category'] ?? '';
$city = $_GET['city'] ?? '';

/* ================= PAGINATION ================= */

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if($page < 1) $page = 1;

$limit = 20;
$offset = ($page - 1) * $limit;

/* ================= STATE FROM CITY ================= */

$state = '';

if($city){
    $stmt = $conn->prepare("
        SELECT state_id FROM cities WHERE slug=? LIMIT 1
    ");
    $stmt->bind_param("s",$city);
    $stmt->execute();
    $res = $stmt->get_result();

    if($res->num_rows > 0){
        $row = $res->fetch_assoc();
        $state = $row['state_id'];
    }
}

include 'header.php';

/* ================= COUNT ================= */

$count_sql = "SELECT COUNT(*) as total FROM escorts WHERE status='active'";

$params = [];
$types = '';

if($category){
    $count_sql .= " AND category_slug=?";
    $params[] = $category;
    $types .= 's';
}

if($city){
    $count_sql .= " AND city_slug=?";
    $params[] = $city;
    $types .= 's';
}

$count_stmt = $conn->prepare($count_sql);

if($params){
    $count_stmt->bind_param($types, ...$params);
}

$count_stmt->execute();
$total_records = $count_stmt->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_records / $limit);

/* ================= MAIN LIST ================= */

$sql = "SELECT * FROM escorts WHERE status='active'";

$params = [];
$types = '';

if($category){
    $sql .= " AND category_slug=?";
    $params[] = $category;
    $types .= 's';
}

if($city){
    $sql .= " AND city_slug=?";
    $params[] = $city;
    $types .= 's';
}

$sql .= " ORDER BY id DESC LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;
$types .= 'ii';

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

/* ================= FILTER DATA ================= */

$cats = $conn->query("SELECT * FROM categories WHERE status='active'");
$states = $conn->query("SELECT * FROM states WHERE status='active'");

$cities = [];

if($state){
    $cities = $conn->query("
        SELECT * FROM cities 
        WHERE state_id='$state' AND status='active'
        ORDER BY name ASC
    ");
}
?>

<style>
.listing-container{
  max-width:1000px;
  margin:auto;
  padding:0 15px;
}

/* CARD */
.listing-card{
  display:flex;
  border-radius:16px;
  overflow:hidden;
  border:1px solid #f2c57c;
  background:#fff;
  margin-bottom:15px;
  position:relative;
  transition:0.3s;
}

.listing-card:hover{
  box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

/* IMAGE */
.listing-img{
  width:120px;
  min-width:150px;
}

.listing-img img{
  width:100%;
  height:100%;
  object-fit:cover;
  display:block;
}

/* BODY */
.listing-body{
  flex:1;
  padding:12px;
  display:flex;
  flex-direction:column;
  gap:6px;
}

/* TITLE */
.listing-title{
  font-size:14px;
  font-weight:700;
  line-height:1.3;
  display:-webkit-box;
  -webkit-line-clamp:2;
  -webkit-box-orient:vertical;
  overflow:hidden;
  word-break:break-word;
}

.listing-title a{
  color:#000;
  text-decoration:none;
  display:block;
}

/* DESCRIPTION */
.listing-desc{
  font-size:13px;
  color:#444;
  line-height:1.5;
  display:-webkit-box;
  -webkit-line-clamp:4;
  -webkit-box-orient:vertical;
  overflow:hidden;
  word-break:break-word;
}

/* META */
.listing-meta{
  display:flex;
  flex-wrap:wrap;
  gap:10px;
  font-size:12px;
  margin-bottom:8px;
}

.meta-item{
  display:flex;
  align-items:center;
  gap:6px;
  color:#555;
}

.meta-item i{
  font-size:11px;
  background:#f3f3f3;
  padding:5px;
  border-radius:50%;
}

/* BUTTONS */
.listing-actions{
  margin-top:auto;
  display:flex;
  justify-content:flex-end;
  gap:10px;
  position:relative;
  z-index:2;
}

/* ICON */
.icon{
  width:38px;
  height:38px;
  border-radius:50%;
  display:flex;
  align-items:center;
  justify-content:center;
  text-decoration:none;
  color:#fff;
  font-size:14px;
  box-shadow:0 4px 10px rgba(0,0,0,0.15);
}

/* COLORS */
.icon.call{
  background:linear-gradient(135deg,#ff2d75,#ff5fa2);
}

.icon.whatsapp{
  background:linear-gradient(135deg,#25D366,#1ebe5d);
}

.icon.telegram{
  background:linear-gradient(135deg,#229ED9,#1c86c9);
}

/* FULL LINK */
.full-link{
  position:absolute;
  top:0;
  left:0;
  width:100%;
  height:100%;
  z-index:1;
}

/* ================= MOBILE ================= */
@media(max-width:768px){
  .listing-card{
    margin:10px 0;
  }

  .listing-img{
    width:100px;
  }

  .listing-title{
    font-size:13px;
  }

  .listing-desc{
    font-size:12px;
  }

  .listing-actions{
    width:100%;
    justify-content:space-between;
    gap:8px;
  }

  .icon{
    flex:1;
    height:44px;
    border-radius:10px;
    font-size:15px;
  }
}
</style>

<div class="listing-container mt-4">

<!-- FILTER -->
<form id="filterForm">
<div class="row g-3 mb-4">

<div class="col-md-3">
<select name="category" class="form-select">
<option value="">Category</option>
<?php while($cat=$cats->fetch_assoc()){ ?>
<option value="<?php echo $cat['slug']; ?>" <?php if($category==$cat['slug']) echo 'selected'; ?>>
<?php echo $cat['name']; ?>
</option>
<?php } ?>
</select>
</div>

<div class="col-md-3">
<select id="state" class="form-select">
<option value="">State</option>
<?php while($st=$states->fetch_assoc()){ ?>
<option value="<?php echo $st['id']; ?>" <?php if($state==$st['id']) echo 'selected'; ?>>
<?php echo $st['name']; ?>
</option>
<?php } ?>
</select>
</div>

<div class="col-md-3">
<select name="city" id="city" class="form-select">
<option value="">City</option>
<?php if($state){ while($c=$cities->fetch_assoc()){ ?>
<option value="<?php echo $c['slug']; ?>" <?php if($city==$c['slug']) echo 'selected'; ?>>
<?php echo $c['name']; ?>
</option>
<?php }} ?>
</select>
</div>

<div class="col-md-3">
<button class="btn btn-pink w-100">Search</button>
</div>

</div>
</form>

<?php if($result->num_rows > 0){ ?>

<?php while($row = $result->fetch_assoc()){ ?>

<div class="listing-card">

  <!-- IMAGE -->
  <div class="listing-img">
    <img src="/uploads/<?php echo !empty($row['profile_image']) ? $row['profile_image'] : 'no-image.png'; ?>" alt="">
  </div>

  <!-- CONTENT -->
  <div class="listing-body">

    <!-- TITLE -->
    <div class="listing-title">
      <a href="/<?php echo $row['category_slug']; ?>/<?php echo $row['city_slug']; ?>/<?php echo $row['slug']; ?>">
      <?php
$title = strip_tags($row['title']);
$words = explode(' ', $title);
$title = implode(' ', array_slice($words, 0, 120));
echo htmlspecialchars($title);
?>
      </a>
    </div>

    <!-- DESCRIPTION -->
<div class="listing-desc">
<?php
$desc = strip_tags($row['description']);
$words = preg_split('/\s+/', $desc);
$limit = 40;

if(count($words) > $limit){
    $desc = implode(' ', array_slice($words, 0, $limit)) . '...';
}

echo htmlspecialchars($desc);
?>
</div>

    <!-- META -->
    <div class="listing-meta">
      <div class="meta-item">
        <i class="fa-solid fa-user"></i>
        <?php echo (int)$row['age']; ?> Years Old
      </div>

      <div class="meta-item">
        <i class="fa-solid fa-location-dot"></i>
        <?php echo htmlspecialchars(ucwords(str_replace('-', ' ', $row['city_slug']))); ?>
      </div>
    </div>

<!-- ACTION BUTTONS -->
<div class="listing-actions">
  
  <?php
$display_phone = $row['phone'];

if(empty($display_phone)){
    $q = $conn->prepare("
        SELECT phone 
        FROM state_default_numbers 
        WHERE state_id=? 
        LIMIT 1
    ");

    $q->bind_param("i", $row['state_id']);
    $q->execute();

    $res = $q->get_result()->fetch_assoc();

    if($res && !empty($res['phone'])){
        $display_phone = $res['phone'];
    }
}
?>

<?php if(!empty($display_phone)){ ?>
<a href="tel:<?php echo $display_phone; ?>" class="icon call">
        <i class="fa fa-phone"></i>
      </a>
    <?php } ?>

    <?php if(!empty($display_phone)){ ?>
     <a href="https://wa.me/91<?php echo $display_phone; ?>" target="_blank" class="icon whatsapp">
        <i class="fab fa-whatsapp"></i>
      </a>
    <?php } ?>

    <?php if(!empty($row['telegram'])){ ?>
      <a href="<?php echo $row['telegram']; ?>" target="_blank" class="icon telegram">
        <i class="fa fa-paper-plane"></i>
      </a>
    <?php } ?>

</div>
  </div>

  <!-- FULL CLICK -->
  <a href="/<?php echo $row['category_slug']; ?>/<?php echo $row['city_slug']; ?>/<?php echo $row['slug']; ?>" class="full-link"></a>

</div>

<?php } ?>

<?php } else { ?>

<div class="alert alert-warning text-center">
  No listings found.
</div>

<?php } ?>

<!-- PAGINATION -->
<?php if($total_pages > 1){ ?>

<div class="text-center mt-4">

<?php if($page > 1){ ?>
<a href="?category=<?php echo $category; ?>&city=<?php echo $city; ?>&state=<?php echo $state; ?>&page=<?php echo $page-1; ?>">⬅ Prev</a>
<?php } ?>

<?php for($i=1; $i <= $total_pages; $i++){ ?>
<a href="?category=<?php echo $category; ?>&city=<?php echo $city; ?>&state=<?php echo $state; ?>&page=<?php echo $i; ?>"
style="margin:5px; <?php if($i==$page) echo 'font-weight:bold;'; ?>">
<?php echo $i; ?>
</a>
<?php } ?>

<?php if($page < $total_pages){ ?>
<a href="?category=<?php echo $category; ?>&city=<?php echo $city; ?>&state=<?php echo $state; ?>&page=<?php echo $page+1; ?>">Next ➡</a>
<?php } ?>

</div>

<?php } ?>

<?php
/* ================= SEO CONTENT ================= */

$seo = $conn->prepare("
SELECT * FROM seo_content
WHERE category_slug=?
LIMIT 1
");

$seo->bind_param("s",$category);
$seo->execute();

$seo_result = $seo->get_result();

if($seo_result->num_rows > 0){

$seo_row = $seo_result->fetch_assoc();

$cityName = ucwords(str_replace('-', ' ', $city));

$title = $seo_row['title'];
$content = $seo_row['content'];

$cities = [
'Adilabad','Noida','Ahmedabad','Mumbai','Delhi','Kolkata','Pune','Hyderabad'
];

$title = str_replace($cities, $cityName, $title);
$content = str_replace($cities, $cityName, $content);
?>

<?php if(!empty($content)){ ?>

<div class="seo-content mt-5">
<h1><?php echo $title; ?></h1>
<div class="seo-text">
<?php echo $content; ?>
</div>
</div>

<?php
/* ================= HIGH DEMAND CITIES ================= */

$city_name = ucwords(str_replace('-', ' ', $city));

$high_cities = $conn->query("
  SELECT name, slug 
  FROM cities 
  WHERE state_id='$state' AND status='active'
  ORDER BY name ASC
  LIMIT 20
");
?>

<div class="similar-section">

  <h5 class="text-center mb-3">
    Similar top Cities Like <?php echo $city_name; ?>
  </h5>

  <div class="text-center mb-4">
    <a href="#" class="city-pill active">
      <?php echo $city_name; ?>
    </a>
  </div>

  <h6 class="text-center mb-3">
    High Demand Cities to <?php echo $city_name; ?>
  </h6>

  <div class="city-tags text-center">
    <?php while($c = $high_cities->fetch_assoc()){ ?>
      <a href="/<?php echo $category; ?>/<?php echo $c['slug']; ?>" class="city-pill">
        <?php echo $c['name']; ?>
      </a>
    <?php } ?>
  </div>

  <div class="disclaimer mt-4">
    <p><strong>inscallup is not responsible for the accuracy of ads or the conduct of advertisers and users.</strong></p>
    <p>By visiting this website, you acknowledge and agree that our Terms of Use govern your access and may be updated or amended without notice.</p>
    <p>All advertisements are published under the responsibility of advertisers. We do not verify legality, accuracy, or content.</p>
    <p>This platform works only as a listing service. All transactions are directly between users and advertisers.</p>
  </div>

</div>

<style>
.similar-section{
  max-width:900px;
  margin:40px auto;
  padding:0 15px;
  text-align:center;
}

.city-pill{
  display:inline-block;
  padding:6px 14px;
  border:1px solid #ccc;
  border-radius:20px;
  margin:6px;
  font-size:13px;
  color:#333;
  text-decoration:none;
  transition:0.2s;
}

.city-pill:hover{
  background:#f5f5f5;
}

.city-pill.active{
  border:1px solid #4a90e2;
  color:#4a90e2;
}

.disclaimer{
  font-size:13px;
  color:#555;
  text-align:left;
  margin-top:25px;
  line-height:1.6;
}
</style>

<?php } ?>

<?php } ?>

</div>

<script>
// STATE → CITY LOAD
document.getElementById("state").addEventListener("change", function(){
    let state_id = this.value;

    fetch("/get-cities.php?state_id=" + state_id)
    .then(res => res.text())
    .then(data => {
        document.getElementById("city").innerHTML = data;
    });
});

// SEARCH
document.getElementById("filterForm").addEventListener("submit", function(e){
    e.preventDefault();

    let category = document.querySelector("[name='category']").value;
    let city = document.getElementById("city").value;

    if(category && city){
        window.location.href = "/" + category + "/" + city;
    }
});
</script>

<?php include 'footer.php'; ?>
