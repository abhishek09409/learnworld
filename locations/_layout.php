<?php
/**
 * =====================================================
 * SWAPNAVENNAM-STYLE PREMIUM LAYOUT
 * =====================================================
 * Shared layout for all 12 Hyderabad area pages.
 * Design system: dark background, gold + rose accents,
 * Cinzel + Cormorant Garamond + Poppins fonts.
 *
 * Each area page passes a $page array and calls
 * render_swapna_page($page).
 */

/**
 * Image path resolution for area pages inside /locations/ subfolder.
 *
 * File system check uses __DIR__ which points to /locations/, so we go
 * up one level (../) to reach the project root where images/ lives.
 *
 * Returned URL is also relative ("../images/...") so the page works
 * whether the site is hosted at the document root OR inside a sub-folder
 * (like example.com/learnworld/).
 *
 * Both .jpg / .jpeg / .png / .webp variants are auto-detected.
 */
if (!function_exists('get_profile_image')) {
    function get_profile_image($girl, $image_dir) {
        $base       = pathinfo($girl['image'], PATHINFO_FILENAME);
        $extensions = ['jpg', 'jpeg', 'png', 'webp', 'JPG', 'JPEG', 'PNG', 'WEBP'];

        // 1. Try exact filename first
        if (file_exists(__DIR__ . '/../' . $image_dir . $girl['image'])) {
            return '../' . $image_dir . $girl['image'];
        }
        // 2. Try other extensions with same base name
        foreach ($extensions as $ext) {
            $candidate = $image_dir . $base . '.' . $ext;
            if (file_exists(__DIR__ . '/../' . $candidate)) {
                return '../' . $candidate;
            }
        }
        // 3. Fallback to themed placeholder
        return "https://placehold.co/600x800/{$girl['color']}/{$girl['text']}?text="
             . urlencode($girl['name']) . "&font=playfair";
    }
}

if (!function_exists('get_banner_image')) {
    function get_banner_image($banner, $banner_dir) {
        $base       = pathinfo($banner['file'], PATHINFO_FILENAME);
        $extensions = ['jpg', 'jpeg', 'png', 'webp', 'JPG', 'JPEG', 'PNG', 'WEBP'];

        if (file_exists(__DIR__ . '/../' . $banner_dir . $banner['file'])) {
            return '../' . $banner_dir . $banner['file'];
        }
        foreach ($extensions as $ext) {
            $candidate = $banner_dir . $base . '.' . $ext;
            if (file_exists(__DIR__ . '/../' . $candidate)) {
                return '../' . $candidate;
            }
        }
        return "https://placehold.co/1200x500/{$banner['color']}/{$banner['text']}?text="
             . urlencode(strip_tags($banner['caption'])) . "&font=playfair";
    }
}

if (!function_exists('render_swapna_page')) {

function render_swapna_page(array $p) {
    // Required keys
    $area        = $p['area'];
    $area_slug   = $p['area_slug'];
    $brand       = $p['brand'] ?? ($area . ' Escorts');
    $page_title  = $p['page_title'];
    $page_desc   = $p['page_desc'];
    $contact_no  = $p['contact_no']  ?? '+91 00000 00000';
    $whatsapp_no = $p['whatsapp_no'] ?? '+91 00000 00000';
    $intro_paragraphs = $p['intro_paragraphs'] ?? [];
    $sections    = $p['sections']    ?? [];
    $guide_intro = $p['guide_intro'] ?? [];
    $guide_steps = $p['guide_steps'] ?? [];
    $gallery     = $p['gallery']     ?? [];
    $content_banners = $p['content_banners'] ?? [];

    // Image directories
    $image_dir  = $p['image_dir']  ?? 'images/girls/';
    $banner_dir = $p['banner_dir'] ?? 'images/banners/';

    // Build banner lookup by section index
    $banners_by_section = [];
    foreach ($content_banners as $b) {
        $banners_by_section[$b['after_section']] = $b;
    }

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page_desc); ?>">
    <link rel="canonical" href="/locations/<?php echo $area_slug; ?>.php">

    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Premium Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;900&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-dark:        #0a0a0a;
            --bg-card:        #141414;
            --bg-card-hover:  #1c1c1c;
            --gold:           #d4af37;
            --gold-light:     #f4d77a;
            --gold-dark:      #a8862a;
            --rose:           #ff4f7b;
            --rose-deep:      #c81d4e;
            --text-light:     #efe7d6;
            --text-muted:     #a89c8a;
            --border-soft:    rgba(212, 175, 55, 0.18);
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            background: radial-gradient(ellipse at top, #1a0d12 0%, #0a0a0a 55%, #050505 100%);
            color: var(--text-light);
            font-family: 'Poppins', sans-serif;
            font-weight: 300;
            line-height: 1.85;
            overflow-x: hidden;
        }
        .top-bar {
            background: linear-gradient(90deg, #000 0%, #1a0d12 50%, #000 100%);
            border-bottom: 1px solid var(--border-soft);
            font-size: 0.85rem; padding: 8px 0; color: var(--gold-light);
        }
        .top-bar a { color: var(--gold-light); text-decoration: none; transition: 0.3s; }
        .top-bar a:hover { color: var(--rose); }
        .navbar-premium {
            background: rgba(10, 10, 10, 0.92);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border-soft);
            padding: 18px 0; transition: all 0.4s ease;
        }
        .navbar-premium.scrolled { padding: 10px 0; box-shadow: 0 4px 30px rgba(0,0,0,0.6); }
        .brand-logo {
            font-family: 'Cinzel', serif; font-weight: 900;
            font-size: 1.85rem; letter-spacing: 4px;
            background: linear-gradient(135deg, var(--gold-light), var(--gold), var(--gold-dark));
            -webkit-background-clip: text; background-clip: text;
            color: transparent; text-decoration: none;
        }
        .brand-tag {
            display: block; font-family: 'Cormorant Garamond', serif;
            font-size: 0.7rem; font-style: italic; letter-spacing: 6px;
            color: var(--text-muted); text-align: center; margin-top: -4px;
        }
        .navbar-premium .nav-link {
            color: var(--text-light) !important; font-weight: 500; font-size: 0.92rem;
            letter-spacing: 1px; text-transform: uppercase; margin: 0 8px; position: relative;
        }
        .navbar-premium .nav-link::after {
            content: ''; position: absolute; bottom: -4px; left: 50%;
            width: 0; height: 2px;
            background: linear-gradient(90deg, var(--gold), var(--rose));
            transition: all 0.3s; transform: translateX(-50%);
        }
        .navbar-premium .nav-link:hover::after { width: 100%; }
        .navbar-premium .nav-link:hover { color: var(--gold) !important; }

        .hero {
            position: relative; min-height: 92vh;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden; text-align: center; padding: 120px 20px 80px;
        }
        .hero::before {
            content: ''; position: absolute; inset: 0;
            background:
                radial-gradient(circle at 20% 30%, rgba(255, 79, 123, 0.15), transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(212, 175, 55, 0.18), transparent 45%),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23d4af37' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: 0;
        }
        .hero-content { position: relative; z-index: 2; max-width: 1100px; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 8px 22px; background: rgba(212, 175, 55, 0.1);
            border: 1px solid var(--gold); border-radius: 100px; color: var(--gold);
            font-family: 'Cormorant Garamond', serif; font-style: italic;
            font-size: 1rem; letter-spacing: 2px; margin-bottom: 24px;
        }
        .hero h1 {
            font-family: 'Cinzel', serif; font-weight: 900;
            font-size: clamp(2.5rem, 6vw, 5.2rem); letter-spacing: 3px;
            line-height: 1.1; margin-bottom: 20px;
            background: linear-gradient(135deg, #fff 0%, var(--gold-light) 40%, var(--gold) 70%, var(--rose) 100%);
            -webkit-background-clip: text; background-clip: text;
            color: transparent; text-shadow: 0 0 60px rgba(212, 175, 55, 0.2);
        }
        .hero-divider {
            width: 240px; height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            margin: 30px auto; position: relative;
        }
        .hero-divider::before {
            content: '\F586'; font-family: 'bootstrap-icons';
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%); background: var(--bg-dark);
            padding: 0 14px; color: var(--gold); font-size: 0.9rem;
        }
        .hero-tagline {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(1.2rem, 2.5vw, 1.7rem); font-style: italic;
            color: var(--text-light); font-weight: 400; margin-bottom: 16px;
        }
        .hero-sub { color: var(--text-muted); font-size: 1.05rem; max-width: 720px; margin: 0 auto 40px; }
        .hero-cta-group { display: flex; gap: 18px; justify-content: center; flex-wrap: wrap; }

        .btn-premium {
            background: linear-gradient(135deg, var(--gold-dark), var(--gold), var(--gold-light));
            color: #1a0d12 !important; font-weight: 600; letter-spacing: 2px;
            text-transform: uppercase; font-size: 0.85rem; padding: 14px 36px;
            border: none; border-radius: 4px; position: relative; overflow: hidden;
            transition: all 0.4s; text-decoration: none;
            display: inline-flex; align-items: center; gap: 10px;
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.35);
        }
        .btn-premium::before {
            content: ''; position: absolute; top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: 0.6s;
        }
        .btn-premium:hover { transform: translateY(-3px); box-shadow: 0 12px 35px rgba(212,175,55,0.55); color: #000 !important; }
        .btn-premium:hover::before { left: 100%; }
        .btn-outline-premium {
            background: transparent; color: var(--gold-light) !important; font-weight: 600;
            letter-spacing: 2px; text-transform: uppercase; font-size: 0.85rem;
            padding: 13px 34px; border: 1.5px solid var(--gold); border-radius: 4px;
            transition: all 0.4s; text-decoration: none;
            display: inline-flex; align-items: center; gap: 10px;
        }
        .btn-outline-premium:hover {
            background: var(--gold); color: #000 !important;
            transform: translateY(-3px); box-shadow: 0 10px 25px rgba(212, 175, 55, 0.4);
        }

        .intro-section { padding: 90px 0 40px; position: relative; }
        .intro-card {
            background: linear-gradient(145deg, var(--bg-card), #0d0d0d);
            border: 1px solid var(--border-soft); padding: 50px;
            border-radius: 12px; position: relative;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }
        .intro-card::before {
            content: ''; position: absolute;
            top: -1px; left: -1px; right: -1px; bottom: -1px;
            background: linear-gradient(135deg, var(--gold), transparent 30%, transparent 70%, var(--rose));
            border-radius: 12px; z-index: -1; opacity: 0.4;
        }
        .intro-card p { font-size: 1.08rem; color: var(--text-light); margin-bottom: 22px; }
        .intro-card p:last-child { margin-bottom: 0; }

        .section-title-wrap { text-align: center; margin-bottom: 60px; }
        .section-eyebrow {
            font-family: 'Cormorant Garamond', serif; font-style: italic;
            font-size: 1.05rem; letter-spacing: 4px; color: var(--gold);
            text-transform: uppercase; margin-bottom: 10px;
        }
        .section-main-title {
            font-family: 'Cinzel', serif; font-weight: 700;
            font-size: clamp(1.8rem, 3.5vw, 2.8rem);
            color: var(--text-light); letter-spacing: 2px; margin-bottom: 18px;
        }
        .ornament { display: flex; align-items: center; justify-content: center; gap: 12px; color: var(--gold); margin: 0 auto 10px; }
        .ornament::before, .ornament::after { content: ''; width: 60px; height: 1px; background: linear-gradient(90deg, transparent, var(--gold)); }
        .ornament::after { background: linear-gradient(90deg, var(--gold), transparent); }

        .content-cards { padding: 40px 0 80px; }
        .content-card {
            background: linear-gradient(145deg, var(--bg-card), #0c0c0c);
            border: 1px solid var(--border-soft); border-radius: 10px;
            padding: 40px 38px; margin-bottom: 28px; position: relative;
            transition: all 0.4s ease; overflow: hidden;
        }
        .content-card::before {
            content: ''; position: absolute; top: 0; left: 0;
            width: 4px; height: 100%;
            background: linear-gradient(180deg, var(--gold), var(--rose));
            transform: scaleY(0); transform-origin: top; transition: transform 0.5s;
        }
        .content-card:hover {
            background: linear-gradient(145deg, var(--bg-card-hover), #111);
            transform: translateY(-4px);
            box-shadow: 0 18px 50px rgba(0,0,0,0.6), 0 0 0 1px var(--gold);
        }
        .content-card:hover::before { transform: scaleY(1); }
        .card-head {
            display: flex; align-items: flex-start; gap: 22px;
            margin-bottom: 22px; padding-bottom: 22px;
            border-bottom: 1px dashed rgba(212,175,55,0.18);
        }
        .icon-orb {
            flex-shrink: 0; width: 60px; height: 60px;
            background: linear-gradient(135deg, rgba(212,175,55,0.18), rgba(255,79,123,0.12));
            border: 1px solid var(--gold); border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; color: var(--gold);
            box-shadow: inset 0 0 20px rgba(212,175,55,0.15);
        }
        .card-title {
            font-family: 'Cinzel', serif; font-weight: 600;
            font-size: 1.35rem; line-height: 1.4; color: var(--gold-light);
            margin: 0; letter-spacing: 0.5px;
        }
        .content-card p { color: var(--text-light); font-size: 1rem; margin-bottom: 16px; }
        .content-card p:last-child { margin-bottom: 0; }
        .premium-list { list-style: none; padding: 0; margin: 18px 0 0; }
        .premium-list li {
            position: relative; padding: 12px 0 12px 38px;
            color: var(--text-light); border-bottom: 1px solid rgba(212,175,55,0.08);
        }
        .premium-list li:last-child { border-bottom: none; }
        .premium-list li::before {
            content: '\F270'; font-family: 'bootstrap-icons';
            position: absolute; left: 0; top: 12px;
            color: var(--gold); font-size: 1rem;
        }

        .gallery-section {
            padding: 100px 0;
            background: radial-gradient(ellipse at top, rgba(212,175,55,0.05), transparent 60%), #060606;
            border-top: 1px solid var(--border-soft); border-bottom: 1px solid var(--border-soft);
            position: relative;
        }
        .profile-card {
            position: relative; background: linear-gradient(145deg, var(--bg-card), #0c0c0c);
            border: 1px solid var(--border-soft); border-radius: 14px; overflow: hidden;
            transition: all 0.5s cubic-bezier(.2,.9,.3,1.2);
            box-shadow: 0 10px 30px rgba(0,0,0,0.4); margin-bottom: 30px;
        }
        .profile-card::before {
            content: ''; position: absolute;
            top: -2px; left: -2px; right: -2px; bottom: -2px;
            background: linear-gradient(135deg, var(--gold), transparent 30%, transparent 70%, var(--rose));
            border-radius: 14px; z-index: -1; opacity: 0; transition: opacity 0.4s;
        }
        .profile-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 25px 60px rgba(212,175,55,0.25), 0 0 0 1px var(--gold);
        }
        .profile-card:hover::before { opacity: 0.6; }
        .profile-img-wrap { position: relative; overflow: hidden; aspect-ratio: 3 / 4; background: #1a0d12; }
        .profile-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.7s ease; display: block; }
        .profile-card:hover .profile-img { transform: scale(1.08) rotate(-1deg); }
        .profile-overlay {
            position: absolute; inset: 0; pointer-events: none;
            background: linear-gradient(180deg, rgba(0,0,0,0.0) 0%, rgba(0,0,0,0.0) 45%, rgba(10,5,8,0.85) 100%);
        }
        .verified-badge {
            position: absolute; top: 14px; left: 14px;
            background: linear-gradient(135deg, #25d366, #0f8f4d); color: #fff;
            font-size: 0.7rem; font-weight: 600; padding: 5px 12px;
            border-radius: 100px; letter-spacing: 1px; text-transform: uppercase;
            display: flex; align-items: center; gap: 5px;
            box-shadow: 0 4px 14px rgba(37,211,102,0.4); z-index: 2;
        }
        .age-badge {
            position: absolute; top: 14px; right: 14px;
            background: linear-gradient(135deg, var(--gold-dark), var(--gold), var(--gold-light));
            color: #1a0d12; font-family: 'Cinzel', serif; font-weight: 700;
            font-size: 0.85rem; padding: 6px 14px; border-radius: 100px;
            letter-spacing: 1px; box-shadow: 0 4px 14px rgba(212,175,55,0.45); z-index: 2;
        }
        .profile-tags { position: absolute; bottom: 14px; left: 14px; right: 14px; display: flex; gap: 6px; flex-wrap: wrap; z-index: 2; }
        .profile-tags .tag {
            background: rgba(255,79,123,0.85); color: #fff; font-size: 0.68rem;
            font-weight: 600; letter-spacing: 1px; padding: 4px 10px;
            border-radius: 4px; text-transform: uppercase; backdrop-filter: blur(6px);
        }
        .profile-tags .tag.gold { background: rgba(212,175,55,0.9); color: #1a0d12; }
        .profile-body { padding: 22px; position: relative; }
        .profile-name { font-family: 'Cinzel', serif; font-weight: 700; font-size: 1.25rem; color: var(--gold-light); margin: 0 0 4px; letter-spacing: 1px; }
        .profile-cat { font-family: 'Cormorant Garamond', serif; font-style: italic; color: var(--text-muted); font-size: 0.95rem; margin-bottom: 14px; }
        .profile-meta {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 16px; padding: 10px 0;
            border-top: 1px dashed rgba(212,175,55,0.18);
            border-bottom: 1px dashed rgba(212,175,55,0.18);
        }
        .meta-item { display: flex; align-items: center; gap: 6px; color: var(--text-light); font-size: 0.85rem; }
        .meta-item i { color: var(--gold); }
        .rating-stars { color: var(--gold); letter-spacing: 1px; font-size: 0.78rem; }
        .rating-stars .num { color: var(--text-light); margin-left: 4px; font-weight: 600; }
        .profile-actions { display: flex; gap: 8px; }
        .btn-mini {
            flex: 1; padding: 10px 12px; border-radius: 6px;
            font-size: 0.78rem; font-weight: 600; letter-spacing: 1px;
            text-transform: uppercase; text-decoration: none; text-align: center;
            transition: all 0.3s; display: inline-flex; align-items: center;
            justify-content: center; gap: 6px; border: none;
        }
        .btn-mini.book { background: linear-gradient(135deg, var(--gold-dark), var(--gold)); color: #1a0d12; }
        .btn-mini.book:hover { background: linear-gradient(135deg, var(--gold), var(--gold-light)); transform: translateY(-2px); box-shadow: 0 8px 18px rgba(212,175,55,0.45); }
        .btn-mini.wa { background: linear-gradient(135deg, #25d366, #128c7e); color: #fff; }
        .btn-mini.wa:hover { transform: translateY(-2px); box-shadow: 0 8px 18px rgba(37,211,102,0.45); }
        .gallery-footer-cta {
            text-align: center; margin-top: 50px; padding: 40px 30px;
            background: linear-gradient(145deg, rgba(212,175,55,0.06), rgba(255,79,123,0.06));
            border: 1px dashed var(--gold); border-radius: 12px;
        }
        .gallery-footer-cta p { color: var(--gold-light); font-family: 'Cormorant Garamond', serif; font-style: italic; font-size: 1.2rem; margin-bottom: 20px; }

        .content-banner {
            position: relative; margin: 50px 0; border-radius: 14px; overflow: hidden;
            border: 1px solid var(--border-soft); box-shadow: 0 18px 50px rgba(0,0,0,0.55);
            transition: all 0.5s ease; cursor: pointer;
        }
        .content-banner::before {
            content: ''; position: absolute;
            top: -2px; left: -2px; right: -2px; bottom: -2px;
            background: linear-gradient(135deg, var(--gold), transparent 30%, transparent 70%, var(--rose));
            border-radius: 14px; z-index: -1; opacity: 0; transition: opacity 0.5s;
        }
        .content-banner:hover { transform: translateY(-6px); box-shadow: 0 25px 70px rgba(212,175,55,0.3), 0 0 0 1px var(--gold); }
        .content-banner:hover::before { opacity: 0.7; }
        .content-banner-img-wrap { position: relative; width: 100%; aspect-ratio: 12 / 5; overflow: hidden; background: #1a0d12; }
        .content-banner img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.9s cubic-bezier(.2,.9,.3,1); }
        .content-banner:hover img { transform: scale(1.06); }
        .content-banner-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(90deg, rgba(10,5,8,0.75) 0%, rgba(10,5,8,0.35) 50%, rgba(10,5,8,0.6) 100%),
                linear-gradient(180deg, rgba(0,0,0,0.2), rgba(10,5,8,0.5));
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            text-align: center; padding: 30px 24px;
        }
        .content-banner-eyebrow { font-family: 'Cormorant Garamond', serif; font-style: italic; font-size: 0.95rem; letter-spacing: 4px; color: var(--gold); text-transform: uppercase; margin-bottom: 10px; }
        .content-banner-caption {
            font-family: 'Cinzel', serif; font-weight: 700;
            font-size: clamp(1.4rem, 3vw, 2.4rem); letter-spacing: 2px; line-height: 1.2;
            background: linear-gradient(135deg, #fff, var(--gold-light), var(--gold));
            -webkit-background-clip: text; background-clip: text;
            color: transparent; text-shadow: 0 0 30px rgba(212,175,55,0.3); margin-bottom: 12px;
        }
        .content-banner-subtitle { font-family: 'Cormorant Garamond', serif; font-style: italic; font-size: clamp(1rem, 1.8vw, 1.25rem); color: var(--text-light); letter-spacing: 1.5px; margin-bottom: 18px; }
        .content-banner-cta {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 26px;
            background: linear-gradient(135deg, var(--gold-dark), var(--gold), var(--gold-light));
            color: #1a0d12 !important; font-weight: 600; font-size: 0.78rem;
            letter-spacing: 2px; text-transform: uppercase; text-decoration: none;
            border-radius: 4px; box-shadow: 0 6px 20px rgba(212,175,55,0.4); transition: all 0.3s;
        }
        .content-banner-cta:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(212,175,55,0.6); color: #000 !important; }
        .content-banner-corner {
            position: absolute; top: 18px; right: 18px;
            background: rgba(255,79,123,0.92); color: #fff;
            font-size: 0.68rem; font-weight: 700; letter-spacing: 2px;
            padding: 5px 12px; border-radius: 4px; text-transform: uppercase;
            backdrop-filter: blur(6px); box-shadow: 0 4px 14px rgba(255,79,123,0.4);
        }
        @media (max-width: 768px) {
            .content-banner-img-wrap { aspect-ratio: 4 / 3; }
            .content-banner-overlay { padding: 20px 16px; }
        }

        .highlight-cta {
            margin: 60px 0; padding: 70px 40px;
            background: linear-gradient(135deg, rgba(212,175,55,0.08), rgba(255,79,123,0.08)),
                radial-gradient(circle at 50% 50%, rgba(212,175,55,0.15), transparent 70%), #0a0a0a;
            border: 1px solid var(--gold); border-radius: 12px;
            text-align: center; position: relative; overflow: hidden;
        }
        .highlight-cta h3 { font-family: 'Cinzel', serif; font-weight: 700; color: var(--gold-light); font-size: clamp(1.5rem, 3vw, 2.2rem); margin-bottom: 16px; letter-spacing: 1.5px; }
        .highlight-cta p { color: var(--text-muted); max-width: 700px; margin: 0 auto 30px; font-size: 1.05rem; }

        .guide-section {
            background: linear-gradient(180deg, transparent, rgba(212,175,55,0.04), transparent), #070707;
            padding: 100px 0;
            border-top: 1px solid var(--border-soft); border-bottom: 1px solid var(--border-soft);
        }
        .guide-intro {
            background: linear-gradient(145deg, var(--bg-card), #0d0d0d);
            border: 1px solid var(--border-soft);
            padding: 40px; border-radius: 12px; margin-bottom: 50px;
        }
        .guide-intro p { color: var(--text-light); font-size: 1.05rem; margin-bottom: 18px; }
        .guide-intro p:last-child { margin-bottom: 0; }
        .step-list { padding: 0; list-style: none; counter-reset: step-counter; }
        .step-list li {
            counter-increment: step-counter; position: relative;
            padding: 28px 30px 28px 100px; margin-bottom: 18px;
            background: linear-gradient(145deg, var(--bg-card), #0d0d0d);
            border: 1px solid var(--border-soft); border-radius: 10px;
            color: var(--text-light); font-size: 1rem; transition: all 0.3s;
        }
        .step-list li::before {
            content: counter(step-counter, decimal-leading-zero);
            position: absolute; left: 25px; top: 50%; transform: translateY(-50%);
            font-family: 'Cinzel', serif; font-size: 2.2rem; font-weight: 700;
            background: linear-gradient(135deg, var(--gold), var(--rose));
            -webkit-background-clip: text; background-clip: text; color: transparent;
        }
        .step-list li:hover { border-color: var(--gold); transform: translateX(8px); box-shadow: -8px 0 25px rgba(212,175,55,0.15); }

        .stats-row { background: #050505; padding: 60px 0; border-top: 1px solid var(--border-soft); }
        .stat-item { text-align: center; padding: 20px; }
        .stat-num {
            font-family: 'Cinzel', serif; font-size: clamp(2.2rem, 5vw, 3.5rem); font-weight: 900;
            background: linear-gradient(135deg, var(--gold-light), var(--gold), var(--rose));
            -webkit-background-clip: text; background-clip: text; color: transparent; line-height: 1;
        }
        .stat-label { color: var(--text-muted); font-size: 0.85rem; letter-spacing: 3px; text-transform: uppercase; margin-top: 10px; }

        .other-areas-section {
            padding: 80px 0; background: #070707;
            border-top: 1px solid var(--border-soft);
        }
        .area-link-card {
            display: block; background: linear-gradient(145deg, var(--bg-card), #0d0d0d);
            border: 1px solid var(--border-soft); border-radius: 10px;
            padding: 18px 20px; text-decoration: none; color: var(--gold-light);
            transition: all 0.3s; height: 100%;
            font-family: 'Cinzel', serif; font-weight: 600; letter-spacing: 1px;
        }
        .area-link-card:hover {
            border-color: var(--gold); transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(212,175,55,0.2);
            color: var(--gold);
        }
        .area-link-card i { float: right; color: var(--rose); margin-top: 4px; }

        footer {
            background: linear-gradient(180deg, #0a0a0a, #000);
            border-top: 1px solid var(--border-soft);
            padding: 60px 0 30px; color: var(--text-muted); text-align: center;
        }
        footer .brand-logo { font-size: 2rem; }
        footer p { font-size: 0.9rem; margin: 18px 0 6px; }
        footer .footer-links { margin: 22px 0; }
        footer .footer-links a {
            color: var(--gold-light); margin: 0 14px; text-decoration: none;
            font-size: 0.85rem; letter-spacing: 1px; text-transform: uppercase; transition: 0.3s;
        }
        footer .footer-links a:hover { color: var(--rose); }
        .footer-divider { height: 1px; background: linear-gradient(90deg, transparent, var(--gold), transparent); margin: 30px 0; }
        .copyright { font-size: 0.78rem; color: #666; letter-spacing: 1px; }

        .float-cta {
            position: fixed; right: 22px; z-index: 999;
            width: 58px; height: 58px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.6rem; text-decoration: none;
            box-shadow: 0 8px 25px rgba(0,0,0,0.5); transition: all 0.3s;
        }
        .float-cta:hover { transform: scale(1.1); color: #fff; }
        .float-whatsapp { bottom: 95px; background: linear-gradient(135deg, #25d366, #128c7e); }
        .float-call { bottom: 22px; background: linear-gradient(135deg, var(--rose), var(--rose-deep)); }

        .reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        @media (max-width: 768px) {
            .intro-card, .guide-intro { padding: 28px; }
            .content-card { padding: 28px 22px; }
            .card-head { flex-direction: column; gap: 14px; }
            .icon-orb { width: 52px; height: 52px; font-size: 1.2rem; }
            .card-title { font-size: 1.15rem; }
            .step-list li { padding: 24px 22px 24px 80px; }
            .step-list li::before { left: 18px; font-size: 1.7rem; }
            .highlight-cta { padding: 50px 24px; }
        }
        .age-banner {
            background: linear-gradient(90deg, rgba(255,79,123,0.12), rgba(212,175,55,0.12));
            border-bottom: 1px solid var(--border-soft);
            padding: 10px 0; text-align: center;
            font-size: 0.82rem; color: var(--gold-light); letter-spacing: 1px;
        }
    </style>
</head>
<body>

<!-- AGE BANNER -->
<div class="age-banner">
    <i class="bi bi-shield-lock-fill me-2"></i>
    <strong>18+ ONLY</strong> &mdash; This website contains adult content. By continuing you confirm you are above the legal age in your region.
</div>

<!-- TOP BAR -->
<div class="top-bar">
    <div class="container d-flex justify-content-between flex-wrap">
        <span><i class="bi bi-clock-history me-2"></i>Available 24/7 &middot; Same-Day Booking &middot; <?php echo htmlspecialchars($area); ?></span>
        <span class="d-none d-md-block">
            <a href="tel:<?php echo $contact_no; ?>"><i class="bi bi-telephone-fill me-1"></i> <?php echo $contact_no; ?></a>
            <span class="mx-3">|</span>
            <a href="https://wa.me/<?php echo preg_replace('/\D/','',$whatsapp_no); ?>"><i class="bi bi-whatsapp me-1"></i> WhatsApp</a>
        </span>
    </div>
</div>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-premium sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/locations/">
            <span class="brand-logo"><?php echo htmlspecialchars($brand); ?></span>
            <span class="brand-tag">PREMIUM <?php echo strtoupper($area); ?> ESCORTS</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span style="color:var(--gold); font-size:1.6rem;"><i class="bi bi-list"></i></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="mainNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#gallery">Gallery</a></li>
                <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#guide">Booking Guide</a></li>
                <li class="nav-item"><a class="nav-link" href="/locations/">Other Areas</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero" id="home">
    <div class="hero-content">
        <div class="hero-badge">
            <i class="bi bi-stars"></i> ELITE &middot; LUXURY &middot; <?php echo strtoupper($area); ?>
        </div>
        <h1><?php echo strtoupper($area); ?></h1>
        <div class="hero-divider"></div>
        <p class="hero-tagline">"<?php echo htmlspecialchars($p['hero_tagline'] ?? 'Premium ' . $area . ' Escort Service for Genuine Adult Entertainment'); ?>"</p>
        <p class="hero-sub"><?php echo $p['hero_sub'] ?? ''; ?></p>
        <div class="hero-cta-group">
            <a href="#gallery" class="btn-premium"><i class="bi bi-images"></i> Browse Gallery</a>
            <a href="#services" class="btn-outline-premium"><i class="bi bi-gem"></i> Our Services</a>
            <a href="https://wa.me/<?php echo preg_replace('/\D/','',$whatsapp_no); ?>" class="btn-outline-premium">
                <i class="bi bi-whatsapp"></i> WhatsApp
            </a>
        </div>
    </div>
</section>

<!-- INTRO -->
<section class="intro-section" id="about">
    <div class="container">
        <div class="section-title-wrap">
            <div class="section-eyebrow">~ Welcome to <?php echo htmlspecialchars($area); ?> ~</div>
            <h2 class="section-main-title">The Premium Choice for <?php echo htmlspecialchars($area); ?> Escorts</h2>
            <div class="ornament"><i class="bi bi-suit-diamond-fill"></i></div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="intro-card reveal">
                    <?php foreach ($intro_paragraphs as $para): ?>
                        <p><?php echo $para; ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- GALLERY -->
<?php if (!empty($gallery)): ?>
<section class="gallery-section" id="gallery">
    <div class="container">
        <div class="section-title-wrap">
            <div class="section-eyebrow">~ Meet Our <?php echo htmlspecialchars($area); ?> Beauties ~</div>
            <h2 class="section-main-title">Premium Call Girls Gallery</h2>
            <div class="ornament"><i class="bi bi-gem"></i></div>
            <p class="text-center" style="color: var(--text-muted); max-width: 700px; margin: 20px auto 0; font-style: italic; font-family: 'Cormorant Garamond', serif; font-size: 1.15rem;">
                Browse our exclusive collection of verified, high-profile call girls available in <?php echo htmlspecialchars($area); ?> &mdash; college girls, housewives, models, airhostesses &amp; VIP companions ready for your erotic fantasies.
            </p>
        </div>
        <div class="row">
            <?php foreach ($gallery as $girl):
                $img = get_profile_image($girl, $image_dir);
                $stars = round($girl['rating']);
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6 reveal">
                    <div class="profile-card">
                        <div class="profile-img-wrap">
                            <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($girl['name']); ?> - <?php echo htmlspecialchars($girl['category']); ?> in <?php echo htmlspecialchars($area); ?>" class="profile-img" loading="lazy">
                            <div class="profile-overlay"></div>
                            <span class="verified-badge"><i class="bi bi-patch-check-fill"></i> Verified</span>
                            <span class="age-badge">Age <?php echo $girl['age']; ?></span>
                            <div class="profile-tags">
                                <?php foreach ($girl['tags'] as $t):
                                    $cls = (in_array(strtolower($t), ['vip','elite','premium','celebrity','top-rated','luxury'])) ? 'tag gold' : 'tag';
                                ?>
                                    <span class="<?php echo $cls; ?>"><?php echo htmlspecialchars($t); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="profile-body">
                            <h3 class="profile-name"><?php echo htmlspecialchars($girl['name']); ?></h3>
                            <div class="profile-cat"><?php echo htmlspecialchars($girl['category']); ?></div>
                            <div class="profile-meta">
                                <span class="meta-item"><i class="bi bi-geo-alt-fill"></i> <?php echo htmlspecialchars($area); ?></span>
                                <span class="rating-stars">
                                    <?php for ($s = 1; $s <= 5; $s++): ?>
                                        <i class="bi <?php echo ($s <= $stars) ? 'bi-star-fill' : 'bi-star'; ?>"></i>
                                    <?php endfor; ?>
                                    <span class="num"><?php echo $girl['rating']; ?></span>
                                </span>
                            </div>
                            <div class="profile-actions">
                                <a href="tel:<?php echo $contact_no; ?>" class="btn-mini book"><i class="bi bi-telephone-fill"></i> Book Now</a>
                                <a href="https://wa.me/<?php echo preg_replace('/\D/','',$whatsapp_no); ?>?text=<?php echo urlencode('Hi, I am interested in booking ' . $girl['name'] . ' (' . $girl['category'] . ') in ' . $area); ?>" class="btn-mini wa">
                                    <i class="bi bi-whatsapp"></i> Chat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="gallery-footer-cta reveal">
            <p>"More than 500+ verified profiles available in <?php echo htmlspecialchars($area); ?>. Find your dream companion now."</p>
            <a href="https://wa.me/<?php echo preg_replace('/\D/','',$whatsapp_no); ?>" class="btn-premium">
                <i class="bi bi-collection-fill"></i> View All Profiles
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CONTENT CARDS -->
<section class="content-cards" id="services">
    <div class="container">
        <div class="section-title-wrap">
            <div class="section-eyebrow">~ Our Premium <?php echo htmlspecialchars($area); ?> Offerings ~</div>
            <h2 class="section-main-title">Genuine Escorts &amp; Call Girls in <?php echo htmlspecialchars($area); ?></h2>
            <div class="ornament"><i class="bi bi-suit-heart-fill"></i></div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <?php foreach ($sections as $index => $sec): ?>
                    <article class="content-card reveal">
                        <div class="card-head">
                            <div class="icon-orb"><i class="bi <?php echo $sec['icon']; ?>"></i></div>
                            <h3 class="card-title"><?php echo $sec['title']; ?></h3>
                        </div>
                        <?php foreach ($sec['content'] as $para): ?>
                            <p><?php echo $para; ?></p>
                        <?php endforeach; ?>
                        <?php if (!empty($sec['list'])): ?>
                            <ul class="premium-list">
                                <?php foreach ($sec['list'] as $li): ?>
                                    <li><?php echo $li; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </article>

                    <?php if ($index === floor(count($sections)/2)): ?>
                        <div class="highlight-cta reveal">
                            <h3><i class="bi bi-telephone-outbound-fill me-2"></i>Book Your Dream Companion in <?php echo htmlspecialchars($area); ?> Tonight</h3>
                            <p>Browse our exclusive collection of high-profile escorts in <?php echo htmlspecialchars($area); ?> &mdash; housewives, college girls, models, airhostesses &amp; VIP companions. Instant booking, complete privacy, 24/7 service.</p>
                            <a href="https://wa.me/<?php echo preg_replace('/\D/','',$whatsapp_no); ?>" class="btn-premium">
                                <i class="bi bi-whatsapp"></i> Chat on WhatsApp
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($banners_by_section[$index])):
                        $banner = $banners_by_section[$index];
                        $banner_src = get_banner_image($banner, $banner_dir);
                    ?>
                        <a href="https://wa.me/<?php echo preg_replace('/\D/','',$whatsapp_no); ?>" class="content-banner reveal" style="text-decoration:none;">
                            <div class="content-banner-img-wrap">
                                <img src="<?php echo $banner_src; ?>" alt="<?php echo strip_tags($banner['caption']); ?>" loading="lazy">
                                <span class="content-banner-corner"><i class="bi bi-fire"></i> Hot</span>
                                <div class="content-banner-overlay">
                                    <div class="content-banner-eyebrow">~ <?php echo htmlspecialchars($brand); ?> Premium ~</div>
                                    <h3 class="content-banner-caption"><?php echo $banner['caption']; ?></h3>
                                    <p class="content-banner-subtitle"><?php echo $banner['subtitle']; ?></p>
                                    <span class="content-banner-cta"><i class="bi bi-whatsapp"></i> Book Now</span>
                                </div>
                            </div>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- GUIDE -->
<?php if (!empty($guide_steps)): ?>
<section class="guide-section" id="guide">
    <div class="container">
        <div class="section-title-wrap">
            <div class="section-eyebrow">~ Step-by-Step Booking Process ~</div>
            <h2 class="section-main-title">How to Book <?php echo htmlspecialchars($area); ?> Escort Online</h2>
            <div class="ornament"><i class="bi bi-bookmark-star-fill"></i></div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <?php if (!empty($guide_intro)): ?>
                    <div class="guide-intro reveal">
                        <?php foreach ($guide_intro as $gp): ?>
                            <p><?php echo $gp; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <ol class="step-list">
                    <?php foreach ($guide_steps as $step): ?>
                        <li class="reveal"><?php echo $step; ?></li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- STATS -->
<section class="stats-row">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-3 stat-item"><div class="stat-num">500+</div><div class="stat-label">Verified Profiles</div></div>
            <div class="col-6 col-md-3 stat-item"><div class="stat-num">24/7</div><div class="stat-label">Available Anytime</div></div>
            <div class="col-6 col-md-3 stat-item"><div class="stat-num">100%</div><div class="stat-label">Privacy Assured</div></div>
            <div class="col-6 col-md-3 stat-item"><div class="stat-num">10K+</div><div class="stat-label">Happy Clients</div></div>
        </div>
    </div>
</section>

<!-- OTHER AREAS -->
<section class="other-areas-section">
    <div class="container">
        <div class="section-title-wrap">
            <div class="section-eyebrow">~ Explore Other Hyderabad Areas ~</div>
            <h2 class="section-main-title">Premium Escorts Across Hyderabad</h2>
            <div class="ornament"><i class="bi bi-geo-alt-fill"></i></div>
        </div>
        <div class="row g-3">
            <?php foreach ($allAreas as $slug => $name):
                if ($slug === $area_slug) continue;
            ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="/locations/<?php echo $slug; ?>.php" class="area-link-card">
                        <?php echo $name; ?> <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer id="contact">
    <div class="container">
        <a href="/locations/" class="brand-logo"><?php echo strtoupper(htmlspecialchars($brand)); ?></a>
        <p class="brand-tag">~ Genuine <?php echo htmlspecialchars($area); ?> Escort Agency ~</p>
        <p>Elite Call Girls &middot; High-Profile Escorts &middot; Discreet Service &middot; 24/7 Booking</p>
        <div class="footer-links">
            <a href="#home">Home</a>
            <a href="#about">About</a>
            <a href="#gallery">Gallery</a>
            <a href="#services">Services</a>
            <a href="#guide">Guide</a>
            <a href="/locations/">Other Areas</a>
            <a href="tel:<?php echo $contact_no; ?>">Call</a>
            <a href="https://wa.me/<?php echo preg_replace('/\D/','',$whatsapp_no); ?>">WhatsApp</a>
        </div>
        <div class="footer-divider"></div>
        <p class="copyright">
            &copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($brand); ?>. All Rights Reserved. &middot; Strictly 18+ &middot; Adults Only
        </p>
    </div>
</footer>

<a href="https://wa.me/<?php echo preg_replace('/\D/','',$whatsapp_no); ?>" class="float-cta float-whatsapp" title="Chat on WhatsApp"><i class="bi bi-whatsapp"></i></a>
<a href="tel:<?php echo $contact_no; ?>" class="float-cta float-call" title="Call Now"><i class="bi bi-telephone-fill"></i></a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const nav = document.querySelector('.navbar-premium');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) nav.classList.add('scrolled');
        else nav.classList.remove('scrolled');
    });
    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                observer.unobserve(e.target);
            }
        });
    }, { threshold: 0.12 });
    reveals.forEach(el => observer.observe(el));
</script>
</body>
</html>
<?php
}
}

/**
 * Standard gallery used by all area pages.
 * Edit names/images as needed.
 */
if (!function_exists('default_area_gallery')) {
function default_area_gallery() {
    return [
        ["name" => "Priya Sharma",   "image" => "priya.jpg",    "category" => "College Girl",     "age" => 22, "rating" => "4.9", "tags" => ["VIP", "GFE"],          "color" => "1a0d12", "text" => "d4af37"],
        ["name" => "Anushka Rao",    "image" => "anushka.jpg",  "category" => "Housewife",        "age" => 28, "rating" => "5.0", "tags" => ["MILF", "Sensual"],     "color" => "0f0a1a", "text" => "f4d77a"],
        ["name" => "Kavya Reddy",    "image" => "kavya.jpg",    "category" => "Air Hostess",      "age" => 25, "rating" => "4.8", "tags" => ["Premium", "Travel"],   "color" => "1a0d12", "text" => "ff4f7b"],
        ["name" => "Riya Mehta",     "image" => "riya.jpg",     "category" => "Fashion Model",    "age" => 24, "rating" => "5.0", "tags" => ["Elite", "Party"],      "color" => "120808", "text" => "d4af37"],
        ["name" => "Tanya Singh",    "image" => "tanya.jpg",    "category" => "VIP Escort",       "age" => 26, "rating" => "4.9", "tags" => ["VIP", "Hi-Profile"],   "color" => "1a0d12", "text" => "f4d77a"],
        ["name" => "Sneha Iyer",     "image" => "sneha.jpg",    "category" => "Russian",          "age" => 23, "rating" => "4.7", "tags" => ["Foreign", "Exotic"],   "color" => "0d141a", "text" => "d4af37"],
        ["name" => "Ananya Das",     "image" => "ananya.jpg",   "category" => "College Girl",     "age" => 21, "rating" => "4.8", "tags" => ["Young", "Cute"],       "color" => "1a0d12", "text" => "ff4f7b"],
        ["name" => "Pooja Verma",    "image" => "pooja.jpg",    "category" => "Actress",          "age" => 29, "rating" => "5.0", "tags" => ["Celebrity", "VIP"],    "color" => "120c0f", "text" => "f4d77a"],
        ["name" => "Naina Khan",     "image" => "naina.jpg",    "category" => "Hot MILF",         "age" => 32, "rating" => "4.9", "tags" => ["Mature", "Bold"],      "color" => "1a0d12", "text" => "d4af37"],
        ["name" => "Divya Joshi",    "image" => "divya.jpg",    "category" => "Independent",      "age" => 25, "rating" => "4.8", "tags" => ["Genuine", "Discreet"], "color" => "0a0a0a", "text" => "ff4f7b"],
        ["name" => "Aarohi Sen",     "image" => "aarohi.jpg",   "category" => "Insta Influencer", "age" => 23, "rating" => "4.9", "tags" => ["Trendy", "Fun"],       "color" => "1a0d12", "text" => "f4d77a"],
        ["name" => "Meera Kapoor",   "image" => "meera.jpg",    "category" => "Premium Model",    "age" => 27, "rating" => "5.0", "tags" => ["Top-Rated", "Luxury"], "color" => "120808", "text" => "d4af37"],
    ];
}
}

if (!function_exists('default_area_banners')) {
function default_area_banners() {
    return [
        ["file" => "banner-1.jpg", "caption" => "Hottest Call Girls",          "subtitle" => "Premium &middot; Verified &middot; Discreet", "color" => "1a0d12", "text" => "d4af37", "after_section" => 1],
        ["file" => "banner-2.jpg", "caption" => "Genuine VIP Escort Service",  "subtitle" => "High-Profile Companions",                     "color" => "0f0a1a", "text" => "f4d77a", "after_section" => 3],
        ["file" => "banner-3.jpg", "caption" => "Independent Beauties",        "subtitle" => "No Agency &middot; Direct Booking",           "color" => "120808", "text" => "ff4f7b", "after_section" => 5],
        ["file" => "banner-4.jpg", "caption" => "College Girls &amp; Models",  "subtitle" => "Young Beauties For You",                      "color" => "1a0d12", "text" => "d4af37", "after_section" => 7],
        ["file" => "banner-5.jpg", "caption" => "24/7 On-Demand Booking",      "subtitle" => "Same-Day Service Available",                  "color" => "0a0a0a", "text" => "ff4f7b", "after_section" => 9],
    ];
}
}

if (!function_exists('default_guide_steps')) {
function default_guide_steps($area) {
    return [
        "First, you need to evaluate your requirements for booking call girls in {$area}. You also need to have a quick look at your budget to book escort girls for sex in {$area}.",
        "Now, you should visit our profile page to browse through various call girl profiles. Here, you can check call girl photos, their erotic services and even WhatsApp number of call girls for sex in {$area}.",
        "Once you choose a call girl for adult services in {$area} online, you need to go through her fees. Knowing the rates of {$area} call girls can help you to make things working within your budget.",
        "If you notice that you can afford hiring a specific call girl for sex in {$area}, you need to ask for her mobile number through our agency.",
        "You can discuss your personalized sex or erotic services with your chosen call girls or escort girls in {$area}.",
        "Now, it's time to decide whether you want to choose an incall or outcall escort service in {$area}.",
        "It's better to choose a secured payment option to make payment for call girl services in {$area}.",
        "Our call girls know how to provide erotic services and sex services to our clients even without unveiling their confidential information.",
        "Booking {$area} call girls is easier and faster than other traditional call girl suppliers in the city.",
    ];
}
}
