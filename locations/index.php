<?php
/**
 * Hyderabad Locations Index Page
 * Lists all 12 premium area pages with cards
 */

$areas = [
    [
        'slug'  => 'kondapur',
        'name'  => 'Kondapur',
        'desc'  => 'IT-corridor lifestyle hub &mdash; modern, central, premium.',
        'image' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=900&q=80',
    ],
    [
        'slug'  => 'hitech-city',
        'name'  => 'Hitech City',
        'desc'  => 'The pulsating heart of Cyberabad &mdash; corporate by day, premium by night.',
        'image' => 'https://images.unsplash.com/photo-1486325212027-8081e485255e?w=900&q=80',
    ],
    [
        'slug'  => 'gachibowli',
        'name'  => 'Gachibowli',
        'desc'  => 'Hyderabad&rsquo;s financial &amp; sports district &mdash; modern and world-class.',
        'image' => 'https://images.unsplash.com/photo-1577415124269-fc1140a69e91?w=900&q=80',
    ],
    [
        'slug'  => 'banjara-hills',
        'name'  => 'Banjara Hills',
        'desc'  => 'The most exclusive address in Hyderabad &mdash; old-money elegance.',
        'image' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=900&q=80',
    ],
    [
        'slug'  => 'madhapur',
        'name'  => 'Madhapur',
        'desc'  => 'The original IT hub &mdash; where Cyberabad first took shape.',
        'image' => 'https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?w=900&q=80',
    ],
    [
        'slug'  => 'jubilee-hills',
        'name'  => 'Jubilee Hills',
        'desc'  => 'Where Hyderabad&rsquo;s celebrities and elite call home &mdash; the gold standard.',
        'image' => 'https://images.unsplash.com/photo-1519074069444-1ba4fff66d16?w=900&q=80',
    ],
    [
        'slug'  => 'somajiguda',
        'name'  => 'Somajiguda',
        'desc'  => 'Hyderabad&rsquo;s central business address &mdash; convenient and classy.',
        'image' => 'https://images.unsplash.com/photo-1551632436-cbf8dd35adfa?w=900&q=80',
    ],
    [
        'slug'  => 'shamshabad',
        'name'  => 'Shamshabad',
        'desc'  => 'The airport gateway &mdash; ideal for transit, layovers and quick stays.',
        'image' => 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=900&q=80',
    ],
    [
        'slug'  => 'begumpet',
        'name'  => 'Begumpet',
        'desc'  => 'Old-Hyderabad charm meets modern hospitality &mdash; central and classic.',
        'image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=900&q=80',
    ],
    [
        'slug'  => 'lakdikapul',
        'name'  => 'Lakdikapul',
        'desc'  => 'A central Hyderabad classic &mdash; calm, well-connected, dignified.',
        'image' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=900&q=80',
    ],
    [
        'slug'  => 'masab-tank',
        'name'  => 'Masab Tank',
        'desc'  => 'A central crossroads &mdash; cosmopolitan and always alive.',
        'image' => 'https://images.unsplash.com/photo-1578922746465-3a80a228f223?w=900&q=80',
    ],
    [
        'slug'  => 'panjagutta',
        'name'  => 'Panjagutta',
        'desc'  => 'Hyderabad&rsquo;s shopping &amp; lifestyle pulse &mdash; central and vibrant.',
        'image' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=900&q=80',
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Premium Hyderabad Areas | Inscallup Locations</title>
<meta name="description" content="Browse premium verified listings across all major Hyderabad neighbourhoods &mdash; Banjara Hills, Jubilee Hills, Hitech City, Gachibowli and more.">
<link rel="canonical" href="/locations/">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
:root{--pink:#ff2d75;--pink-soft:#ff5fa2;--dark:#0f0f1a;--dark-2:#1a1a2e}
*{box-sizing:border-box}
body{font-family:'Inter',sans-serif;background:#fafafa;color:#222;margin:0;line-height:1.6}
h1,h2,h3{font-family:'Playfair Display',serif}

.top-nav{background:linear-gradient(135deg,var(--dark),var(--dark-2));padding:14px 0;position:sticky;top:0;z-index:50;box-shadow:0 2px 20px rgba(0,0,0,.15)}
.top-nav .brand{color:#fff;font-weight:800;font-size:22px;text-decoration:none}
.top-nav .brand span{color:var(--pink)}
.top-nav a.nav-link-c{color:#ddd;text-decoration:none;margin-left:18px;font-size:14px}
.top-nav a.nav-link-c:hover{color:var(--pink-soft)}

.hero{
  min-height:380px;display:flex;align-items:center;justify-content:center;
  text-align:center;color:#fff;position:relative;overflow:hidden;
}
.hero::before{
  content:'';position:absolute;inset:0;
  background:linear-gradient(135deg,rgba(15,15,26,.85),rgba(255,45,117,.55)),
    url('https://images.unsplash.com/photo-1582719508461-905c673771fd?w=1600&q=80') center/cover;
}
.hero-inner{position:relative;z-index:2;max-width:800px;padding:60px 20px}
.hero .eyebrow{display:inline-block;padding:6px 18px;border:1px solid rgba(255,255,255,.4);border-radius:50px;font-size:12px;letter-spacing:3px;text-transform:uppercase;margin-bottom:20px;background:rgba(255,255,255,.08)}
.hero h1{font-size:clamp(36px,5vw,64px);font-weight:800;margin:0 0 14px}
.hero h1 .accent{background:linear-gradient(90deg,#ffd86f,#ff8a4c);-webkit-background-clip:text;background-clip:text;color:transparent}
.hero p{font-size:17px;opacity:.9;font-weight:300}

section{padding:70px 0}
.section-eyebrow{text-transform:uppercase;letter-spacing:3px;color:var(--pink);font-size:12px;font-weight:600;margin-bottom:10px;text-align:center}
.section-title{font-size:clamp(28px,3.5vw,40px);font-weight:700;text-align:center;margin-bottom:18px}
.section-lead{color:#555;font-size:16px;max-width:700px;margin:0 auto 40px;text-align:center}

.area-card{
  display:block;background:#fff;border-radius:20px;overflow:hidden;
  text-decoration:none;color:inherit;height:100%;
  transition:.3s;border:1px solid #f0f0f0;
}
.area-card:hover{transform:translateY(-8px);box-shadow:0 25px 60px rgba(0,0,0,.12);color:inherit}
.area-card-img{position:relative;height:200px;overflow:hidden}
.area-card-img img{width:100%;height:100%;object-fit:cover;transition:.6s}
.area-card:hover .area-card-img img{transform:scale(1.08)}
.area-card-img::after{
  content:'';position:absolute;inset:0;
  background:linear-gradient(180deg,transparent 50%,rgba(15,15,26,.6));
}
.area-card-img .badge-loc{
  position:absolute;top:14px;left:14px;
  background:rgba(255,255,255,.95);color:var(--pink);
  padding:5px 12px;border-radius:20px;font-size:11px;
  font-weight:600;letter-spacing:1px;text-transform:uppercase;
  z-index:2;
}
.area-card-body{padding:22px}
.area-card-body h3{font-size:22px;margin:0 0 8px;color:var(--dark);font-weight:700}
.area-card-body p{color:#666;font-size:14px;margin-bottom:14px;min-height:42px}
.area-card-body .arrow{
  color:var(--pink);font-weight:600;font-size:13px;
  display:inline-flex;align-items:center;gap:6px;
}
.area-card-body .arrow i{transition:.3s}
.area-card:hover .arrow i{transform:translateX(4px)}

footer{background:linear-gradient(135deg,var(--dark),var(--dark-2));color:#bbb;padding:50px 0 25px;margin-top:60px}
footer h6{color:#fff;margin-bottom:18px;font-weight:600}
footer a{color:#aaa;text-decoration:none;font-size:14px;display:block;padding:4px 0}
footer a:hover{color:var(--pink-soft)}
footer .copyright{border-top:1px solid rgba(255,255,255,.08);margin-top:30px;padding-top:20px;font-size:13px;text-align:center;color:#777}
</style>
</head>
<body>

<nav class="top-nav">
  <div class="container d-flex justify-content-between align-items-center">
    <a href="/" class="brand">INS<span>CALLUP</span></a>
    <div class="d-none d-md-flex">
      <a href="/" class="nav-link-c">Home</a>
      <a href="/locations/" class="nav-link-c">Locations</a>
      <a href="/listing.php" class="nav-link-c">Browse</a>
      <a href="/post-ad.php" class="nav-link-c">Post Ad</a>
    </div>
  </div>
</nav>

<header class="hero">
  <div class="hero-inner">
    <span class="eyebrow"><i class="fa-solid fa-location-dot"></i> &nbsp; Hyderabad, Telangana</span>
    <h1>Explore <span class="accent">Premium Areas</span> of Hyderabad</h1>
    <p>Twelve hand-picked neighbourhoods. Verified profiles, total privacy, premium experience.</p>
  </div>
</header>

<section>
  <div class="container">
    <div class="section-eyebrow">All Areas</div>
    <h2 class="section-title">Choose Your Neighbourhood</h2>
    <p class="section-lead">Pick a Hyderabad area to explore curated, verified listings &mdash; with full SEO content, landmarks, FAQs and a refined catalogue tailored to each location.</p>

    <div class="row g-4">
      <?php foreach($areas as $a){ ?>
        <div class="col-md-6 col-lg-4">
          <a href="/locations/<?= $a['slug'] ?>.php" class="area-card">
            <div class="area-card-img">
              <span class="badge-loc">Hyderabad</span>
              <img src="<?= $a['image'] ?>" alt="<?= $a['name'] ?>" loading="lazy">
            </div>
            <div class="area-card-body">
              <h3><?= $a['name'] ?></h3>
              <p><?= $a['desc'] ?></p>
              <span class="arrow">Explore <?= $a['name'] ?> <i class="fa-solid fa-arrow-right"></i></span>
            </div>
          </a>
        </div>
      <?php } ?>
    </div>
  </div>
</section>

<footer>
  <div class="container">
    <div class="row g-4">
      <div class="col-md-4">
        <h6>About Inscallup</h6>
        <p style="font-size:14px">Your trusted platform for premium classified listings across India. Verified profiles, total privacy.</p>
      </div>
      <div class="col-md-4">
        <h6>Top Areas</h6>
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
