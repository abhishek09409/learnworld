<?php
/**
 * =====================================================
 * PREMIUM AREA PAGE LAYOUT (HYDERABAD)
 * =====================================================
 * Shared header, premium CSS and helper renderer used
 * by all 12 Hyderabad area location pages.
 *
 * Each area page passes a $page array and calls
 * render_area_page($page).
 */

if (!function_exists('render_area_page')) {

function render_area_page(array $p) {
    $area       = htmlspecialchars($p['area']);
    $areaSlug   = htmlspecialchars($p['area_slug']);
    $tagline    = htmlspecialchars($p['tagline']);
    $heroImg    = htmlspecialchars($p['hero_image']);
    $metaDesc   = htmlspecialchars($p['meta_desc']);
    $landmarks  = $p['landmarks']  ?? [];
    $faqs       = $p['faqs']       ?? [];
    $sections   = $p['sections']   ?? []; // [['title'=>..,'image'=>..,'body'=>..],...]
    $gallery    = $p['gallery']    ?? [];
    $stats      = $p['stats'] ?? [
        ['num' => '500+',  'label' => 'Verified Profiles'],
        ['num' => '24/7',  'label' => 'Always Available'],
        ['num' => '100%',  'label' => 'Privacy Assured'],
        ['num' => '4.8',   'label' => 'User Rating'],
    ];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= $area ?> Premium Listings | Hyderabad | Inscallup</title>
<meta name="description" content="<?= $metaDesc ?>">
<meta name="keywords" content="<?= strtolower($area) ?> hyderabad, <?= strtolower($area) ?> listings, <?= strtolower($area) ?> classified, hyderabad <?= strtolower($area) ?>">
<link rel="canonical" href="/locations/<?= $areaSlug ?>.php">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
:root{
  --pink:#ff2d75;
  --pink-soft:#ff5fa2;
  --gold:#d4af37;
  --dark:#0f0f1a;
  --dark-2:#1a1a2e;
  --muted:#6c757d;
  --bg:#fafafa;
}

*{box-sizing:border-box}
body{
  font-family:'Inter',sans-serif;
  background:var(--bg);
  color:#222;margin:0;line-height:1.6;
}
h1,h2,h3,h4{font-family:'Playfair Display',serif;letter-spacing:-.5px}

/* ===== TOP BAR ===== */
.top-nav{
  background:linear-gradient(135deg,var(--dark),var(--dark-2));
  padding:14px 0;position:sticky;top:0;z-index:50;
  box-shadow:0 2px 20px rgba(0,0,0,.15);
}
.top-nav .brand{color:#fff;font-weight:800;font-size:22px;text-decoration:none;letter-spacing:1px}
.top-nav .brand span{color:var(--pink)}
.top-nav a.nav-link-c{color:#ddd;text-decoration:none;margin-left:18px;font-size:14px}
.top-nav a.nav-link-c:hover{color:var(--pink-soft)}

/* ===== HERO ===== */
.hero{position:relative;min-height:520px;display:flex;align-items:center;justify-content:center;text-align:center;color:#fff;overflow:hidden}
.hero::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(15,15,26,.85),rgba(255,45,117,.55));z-index:1}
.hero-bg{position:absolute;inset:0;background-size:cover;background-position:center;filter:brightness(.85);transform:scale(1.05)}
.hero-inner{position:relative;z-index:2;max-width:900px;padding:60px 20px}
.hero .eyebrow{display:inline-block;padding:6px 18px;border:1px solid rgba(255,255,255,.4);border-radius:50px;font-size:12px;letter-spacing:3px;text-transform:uppercase;margin-bottom:20px;backdrop-filter:blur(6px);background:rgba(255,255,255,.08)}
.hero h1{font-size:clamp(38px,6vw,72px);font-weight:800;margin:0 0 14px;line-height:1.05;text-shadow:0 4px 20px rgba(0,0,0,.4)}
.hero h1 .accent{background:linear-gradient(90deg,#ffd86f,#ff8a4c);-webkit-background-clip:text;background-clip:text;color:transparent}
.hero .tagline{font-size:18px;opacity:.9;margin-bottom:30px;font-weight:300}
.hero-cta{display:inline-flex;gap:12px;flex-wrap:wrap;justify-content:center}

.btn-premium{
  background:linear-gradient(135deg,var(--pink),var(--pink-soft));
  color:#fff;padding:14px 32px;border:0;border-radius:50px;font-weight:600;
  text-decoration:none;display:inline-flex;align-items:center;gap:8px;
  box-shadow:0 10px 30px rgba(255,45,117,.4);transition:.3s;
}
.btn-premium:hover{transform:translateY(-2px);box-shadow:0 15px 40px rgba(255,45,117,.55);color:#fff}
.btn-ghost{background:transparent;color:#fff;border:1px solid rgba(255,255,255,.5);padding:14px 32px;border-radius:50px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:.3s}
.btn-ghost:hover{background:#fff;color:var(--dark)}

/* ===== BREADCRUMB ===== */
.breadcrumb-bar{background:#fff;border-bottom:1px solid #eee;padding:14px 0;font-size:13px}
.breadcrumb-bar a{color:var(--pink);text-decoration:none}
.breadcrumb-bar i{margin:0 8px;color:#bbb;font-size:10px}

/* ===== STATS ===== */
.stats{margin-top:-60px;position:relative;z-index:5}
.stat-card{background:#fff;border-radius:16px;padding:24px 18px;text-align:center;box-shadow:0 10px 40px rgba(0,0,0,.08);border:1px solid #f1f1f1;transition:.3s;height:100%}
.stat-card:hover{transform:translateY(-5px);box-shadow:0 20px 50px rgba(0,0,0,.12)}
.stat-card .num{font-family:'Playfair Display',serif;font-size:34px;font-weight:800;background:linear-gradient(135deg,var(--pink),var(--pink-soft));-webkit-background-clip:text;background-clip:text;color:transparent}
.stat-card .label{color:#666;font-size:13px;text-transform:uppercase;letter-spacing:1px;margin-top:6px}

/* ===== SECTION BASE ===== */
section{padding:70px 0}
.section-eyebrow{text-transform:uppercase;letter-spacing:3px;color:var(--pink);font-size:12px;font-weight:600;margin-bottom:10px}
.section-title{font-size:clamp(28px,3.5vw,42px);font-weight:700;margin-bottom:18px}
.section-lead{color:#555;font-size:16px;max-width:720px;margin:0 auto 40px}

/* ===== ALTERNATING IMAGE-CONTENT BLOCK ===== */
.split-block{display:grid;grid-template-columns:1fr 1fr;gap:50px;align-items:center;margin-bottom:80px}
.split-block.reverse{direction:rtl}
.split-block.reverse > *{direction:ltr}
.split-image{position:relative;border-radius:24px;overflow:hidden;box-shadow:0 25px 60px rgba(0,0,0,.15)}
.split-image img{width:100%;height:420px;object-fit:cover;display:block;transition:.6s}
.split-image:hover img{transform:scale(1.05)}
.split-image::after{
  content:'';position:absolute;inset:0;
  background:linear-gradient(135deg,transparent 60%,rgba(255,45,117,.15));
  pointer-events:none;
}
.split-content h3{font-size:30px;color:var(--dark);margin-bottom:18px;line-height:1.2}
.split-content .lead-pink{
  color:var(--pink);font-size:13px;font-weight:600;letter-spacing:3px;
  text-transform:uppercase;margin-bottom:10px;display:block;
}
.split-content p{color:#555;font-size:15.5px;line-height:1.85;margin-bottom:14px}
.split-content ul{padding-left:18px;margin-top:14px}
.split-content li{margin-bottom:8px;color:#444}

/* ===== LANDMARKS ===== */
.area-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(190px,1fr));gap:14px}
.area-pill{
  background:#fff;border:1px solid #eee;border-radius:14px;padding:16px;
  text-align:center;text-decoration:none;color:#333;transition:.25s;
  display:flex;align-items:center;justify-content:center;gap:10px;font-weight:500;
}
.area-pill i{color:var(--pink)}
.area-pill:hover{border-color:var(--pink);color:var(--pink);transform:translateY(-3px);box-shadow:0 10px 25px rgba(255,45,117,.15)}

/* ===== GALLERY ===== */
.gallery-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
.gallery-grid .g-item{
  border-radius:18px;overflow:hidden;height:240px;position:relative;
  box-shadow:0 12px 30px rgba(0,0,0,.1);
}
.gallery-grid .g-item img{width:100%;height:100%;object-fit:cover;transition:.6s}
.gallery-grid .g-item:hover img{transform:scale(1.08)}
.gallery-grid .g-item::before{
  content:'';position:absolute;inset:0;
  background:linear-gradient(180deg,transparent 50%,rgba(0,0,0,.5));z-index:1;
}
.gallery-grid .g-item .caption{
  position:absolute;left:18px;bottom:14px;color:#fff;font-weight:600;
  letter-spacing:.5px;z-index:2;font-size:14px;
}

/* ===== WHY CHOOSE ===== */
.why-card{background:#fff;border-radius:18px;padding:30px 24px;height:100%;border:1px solid #f0f0f0;transition:.3s}
.why-card:hover{transform:translateY(-6px);box-shadow:0 20px 45px rgba(0,0,0,.08)}
.why-icon{width:60px;height:60px;border-radius:16px;background:linear-gradient(135deg,var(--pink),var(--pink-soft));display:flex;align-items:center;justify-content:center;color:#fff;font-size:24px;margin-bottom:18px;box-shadow:0 8px 20px rgba(255,45,117,.3)}
.why-card h4{font-size:18px;margin-bottom:8px;color:var(--dark)}
.why-card p{color:#666;font-size:14px;margin:0}

/* ===== FAQ ===== */
.faq-item{background:#fff;border-radius:14px;border:1px solid #eee;margin-bottom:12px;overflow:hidden;transition:.3s}
.faq-q{padding:18px 22px;font-weight:600;color:var(--dark);cursor:pointer;display:flex;justify-content:space-between;align-items:center;font-size:15px}
.faq-q:hover{color:var(--pink)}
.faq-q i{transition:.3s;color:var(--pink)}
.faq-item.open .faq-q i{transform:rotate(45deg)}
.faq-a{max-height:0;overflow:hidden;transition:max-height .35s ease;padding:0 22px;color:#555;font-size:14.5px}
.faq-item.open .faq-a{max-height:600px;padding:0 22px 20px}

/* ===== CTA ===== */
.cta-banner{background:linear-gradient(135deg,var(--dark),var(--dark-2));border-radius:24px;padding:60px 40px;text-align:center;color:#fff;position:relative;overflow:hidden}
.cta-banner::before{content:'';position:absolute;top:-50%;right:-20%;width:500px;height:500px;background:radial-gradient(circle,rgba(255,45,117,.3),transparent 70%)}
.cta-banner h2{position:relative;font-size:36px;margin-bottom:14px;color:#fff}
.cta-banner p{position:relative;opacity:.85;margin-bottom:26px;font-size:16px}

/* ===== OTHER AREAS ===== */
.area-link{display:block;background:#fff;padding:18px;border-radius:14px;text-decoration:none;color:#333;border:1px solid #eee;transition:.3s}
.area-link:hover{border-color:var(--pink);transform:translateY(-3px);box-shadow:0 10px 25px rgba(0,0,0,.08)}
.area-link h5{margin:0;color:var(--dark);font-family:'Inter',sans-serif;font-weight:600;font-size:16px}
.area-link span{color:#999;font-size:12px}
.area-link i{color:var(--pink);float:right;margin-top:4px}

/* ===== FOOTER ===== */
footer{background:linear-gradient(135deg,var(--dark),var(--dark-2));color:#bbb;padding:50px 0 25px;margin-top:60px}
footer h6{color:#fff;margin-bottom:18px;font-family:'Inter',sans-serif;font-weight:600}
footer a{color:#aaa;text-decoration:none;font-size:14px;display:block;padding:4px 0}
footer a:hover{color:var(--pink-soft)}
footer .copyright{border-top:1px solid rgba(255,255,255,.08);margin-top:30px;padding-top:20px;font-size:13px;text-align:center;color:#777}

/* ===== MOBILE ===== */
@media(max-width:992px){
  .split-block{grid-template-columns:1fr;gap:30px;margin-bottom:60px}
  .split-block.reverse{direction:ltr}
  .split-image img{height:300px}
  .gallery-grid{grid-template-columns:repeat(2,1fr)}
  .gallery-grid .g-item{height:180px}
}
@media(max-width:768px){
  .hero{min-height:440px}
  .hero-inner{padding:40px 16px}
  section{padding:50px 0}
  .cta-banner{padding:40px 22px}
  .stats{margin-top:-40px}
  .stat-card .num{font-size:26px}
  .gallery-grid{grid-template-columns:1fr}
}
</style>
</head>
<body>

<!-- TOP NAV -->
<nav class="top-nav">
  <div class="container d-flex justify-content-between align-items-center">
    <a href="/" class="brand">INS<span>CALLUP</span></a>
    <div class="d-none d-md-flex">
      <a href="/" class="nav-link-c">Home</a>
      <a href="/locations/" class="nav-link-c">Hyderabad Areas</a>
      <a href="/listing.php" class="nav-link-c">Browse</a>
      <a href="/post-ad.php" class="nav-link-c">Post Ad</a>
    </div>
  </div>
</nav>

<!-- HERO -->
<header class="hero">
  <div class="hero-bg" style="background-image:url('<?= $heroImg ?>')"></div>
  <div class="hero-inner">
    <span class="eyebrow"><i class="fa-solid fa-location-dot"></i> &nbsp; Hyderabad, Telangana</span>
    <h1>Premium Listings in <span class="accent"><?= $area ?></span></h1>
    <p class="tagline"><?= $tagline ?></p>
    <div class="hero-cta">
      <a href="/listing.php?city=<?= $areaSlug ?>" class="btn-premium">
        <i class="fa-solid fa-fire"></i> Browse <?= $area ?> Listings
      </a>
      <a href="#about" class="btn-ghost">
        <i class="fa-solid fa-circle-info"></i> About <?= $area ?>
      </a>
    </div>
  </div>
</header>

<!-- BREADCRUMB -->
<div class="breadcrumb-bar">
  <div class="container">
    <a href="/">Home</a>
    <i class="fa-solid fa-chevron-right"></i>
    <a href="/locations/">Hyderabad</a>
    <i class="fa-solid fa-chevron-right"></i>
    <span class="text-muted"><?= $area ?></span>
  </div>
</div>

<!-- STATS -->
<section class="stats" style="padding:0">
  <div class="container">
    <div class="row g-3">
      <?php foreach($stats as $s){ ?>
        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="num"><?= htmlspecialchars($s['num']) ?></div>
            <div class="label"><?= htmlspecialchars($s['label']) ?></div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</section>

<!-- ALTERNATING IMAGE / TEXT SECTIONS (1000+ words content) -->
<section id="about">
  <div class="container">
    <div class="text-center">
      <div class="section-eyebrow">About <?= $area ?></div>
      <h2 class="section-title">Discover Premium <?= $area ?></h2>
      <p class="section-lead">Hand-picked listings, verified profiles and a refined experience &mdash; tailored for the <?= $area ?> neighbourhood.</p>
    </div>

    <?php $i = 0; foreach($sections as $sec){ $reverse = ($i % 2 === 1); ?>
      <div class="split-block <?= $reverse ? 'reverse' : '' ?>">
        <div class="split-image">
          <img src="<?= htmlspecialchars($sec['image']) ?>" alt="<?= htmlspecialchars($sec['title']) ?> in <?= $area ?>" loading="lazy">
        </div>
        <div class="split-content">
          <span class="lead-pink"><?= htmlspecialchars($sec['eyebrow'] ?? 'Section ' . ($i+1)) ?></span>
          <h3><?= htmlspecialchars($sec['title']) ?></h3>
          <?= $sec['body'] ?>
        </div>
      </div>
    <?php $i++; } ?>
  </div>
</section>

<!-- GALLERY -->
<?php if(!empty($gallery)){ ?>
<section style="background:linear-gradient(180deg,#fff,#fafafa);padding-top:30px">
  <div class="container">
    <div class="text-center">
      <div class="section-eyebrow">Vibe</div>
      <h2 class="section-title"><?= $area ?> at a Glance</h2>
      <p class="section-lead">A peek into the lifestyle, landmarks and energy that define <?= $area ?>.</p>
    </div>
    <div class="gallery-grid">
      <?php foreach($gallery as $g){ ?>
        <div class="g-item">
          <img src="<?= htmlspecialchars($g['image']) ?>" alt="<?= htmlspecialchars($g['caption']) ?>" loading="lazy">
          <span class="caption"><?= htmlspecialchars($g['caption']) ?></span>
        </div>
      <?php } ?>
    </div>
  </div>
</section>
<?php } ?>

<!-- LANDMARKS -->
<?php if(!empty($landmarks)){ ?>
<section>
  <div class="container">
    <div class="text-center">
      <div class="section-eyebrow">Coverage</div>
      <h2 class="section-title">Landmarks Near <?= $area ?></h2>
      <p class="section-lead">We cover all major spots and sub-localities &mdash; pick a landmark to find listings nearby.</p>
    </div>
    <div class="area-grid">
      <?php foreach($landmarks as $a){ ?>
        <a href="/listing.php?city=<?= $areaSlug ?>" class="area-pill">
          <i class="fa-solid fa-map-pin"></i> <?= htmlspecialchars($a) ?>
        </a>
      <?php } ?>
    </div>
  </div>
</section>
<?php } ?>

<!-- WHY CHOOSE -->
<section style="background:#fff">
  <div class="container">
    <div class="text-center">
      <div class="section-eyebrow">Why Inscallup</div>
      <h2 class="section-title">A Premium Experience in <?= $area ?></h2>
      <p class="section-lead">Built around trust, privacy and quality &mdash; here&rsquo;s what makes us the preferred choice.</p>
    </div>
    <div class="row g-4">
      <div class="col-md-6 col-lg-3">
        <div class="why-card">
          <div class="why-icon"><i class="fa-solid fa-shield-halved"></i></div>
          <h4>100% Verified</h4>
          <p>Every <?= $area ?> profile passes manual verification before listing.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="why-card">
          <div class="why-icon"><i class="fa-solid fa-lock"></i></div>
          <h4>Total Privacy</h4>
          <p>We never share your data. Direct, encrypted contact channels only.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="why-card">
          <div class="why-icon"><i class="fa-solid fa-clock"></i></div>
          <h4>24/7 Available</h4>
          <p>Active listings around the clock with quick-response advertisers.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="why-card">
          <div class="why-icon"><i class="fa-solid fa-star"></i></div>
          <h4>Premium Quality</h4>
          <p>Hand-picked listings &mdash; no spam, no duplicates, no fake profiles.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FAQ -->
<?php if(!empty($faqs)){ ?>
<section>
  <div class="container">
    <div class="text-center">
      <div class="section-eyebrow">Help Center</div>
      <h2 class="section-title">Frequently Asked Questions</h2>
      <p class="section-lead">Quick answers to common questions about <?= $area ?> listings.</p>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-9">
        <?php foreach($faqs as $f){ ?>
          <div class="faq-item">
            <div class="faq-q" onclick="this.parentElement.classList.toggle('open')">
              <span><?= htmlspecialchars($f['q']) ?></span>
              <i class="fa-solid fa-plus"></i>
            </div>
            <div class="faq-a"><?= $f['a'] ?></div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</section>
<?php } ?>

<!-- CTA -->
<section>
  <div class="container">
    <div class="cta-banner">
      <h2>Ready to Explore <?= $area ?>?</h2>
      <p>Browse hundreds of verified listings or post your own ad &mdash; it takes less than a minute.</p>
      <a href="/listing.php?city=<?= $areaSlug ?>" class="btn-premium">
        <i class="fa-solid fa-arrow-right"></i> Browse <?= $area ?> Listings
      </a>
    </div>
  </div>
</section>

<!-- OTHER AREAS -->
<section style="background:#fff;padding-top:30px">
  <div class="container">
    <div class="text-center">
      <div class="section-eyebrow">Explore</div>
      <h2 class="section-title">Other Hyderabad Areas</h2>
      <p class="section-lead">Looking elsewhere in Hyderabad? Here are our other premium area pages.</p>
    </div>
    <div class="row g-3">
      <?php
      $allAreas = [
        'kondapur'      => 'Kondapur',
        'hitech-city'   => 'Hitech City',
        'gachibowli'    => 'Gachibowli',
        'banjara-hills' => 'Banjara Hills',
        'madhapur'      => 'Madhapur',
        'jubilee-hills' => 'Jubilee Hills',
        'somajiguda'    => 'Somajiguda',
        'shamshabad'    => 'Shamshabad',
        'begumpet'      => 'Begumpet',
        'lakdikapul'    => 'Lakdikapul',
        'masab-tank'    => 'Masab Tank',
        'panjagutta'    => 'Panjagutta',
      ];
      foreach($allAreas as $slug=>$name){
        if($slug === $areaSlug) continue;
      ?>
        <div class="col-6 col-md-4 col-lg-3">
          <a href="/locations/<?= $slug ?>.php" class="area-link">
            <h5><?= $name ?> <i class="fa-solid fa-arrow-right"></i></h5>
            <span>Hyderabad</span>
          </a>
        </div>
      <?php } ?>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="container">
    <div class="row g-4">
      <div class="col-md-4">
        <h6>About Inscallup</h6>
        <p style="font-size:14px">Your trusted platform for premium classified listings across India. Verified profiles, total privacy.</p>
      </div>
      <div class="col-md-4">
        <h6>Top Hyderabad Areas</h6>
        <a href="/locations/banjara-hills.php">Banjara Hills</a>
        <a href="/locations/jubilee-hills.php">Jubilee Hills</a>
        <a href="/locations/hitech-city.php">Hitech City</a>
        <a href="/locations/gachibowli.php">Gachibowli</a>
      </div>
      <div class="col-md-4">
        <h6>Quick Links</h6>
        <a href="/">Home</a>
        <a href="/listing.php">All Listings</a>
        <a href="/post-ad.php">Post an Ad</a>
        <a href="/locations/">All Areas</a>
      </div>
    </div>
    <div class="copyright">
      &copy; <?= date('Y') ?> Inscallup. All rights reserved. | Listings are user-submitted; we are a listing service only.
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
}
}
