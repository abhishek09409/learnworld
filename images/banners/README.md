# 🖼️ Inline Content Banner Images

Ye folder content sections ke beech mein dikhne wale **wide banner images** ke liye hai.
Jo escort sites pe content ke beech mein bade promotional images dikhte hain — wahi system.

## How to Add Images (Step-by-Step)

1. **Image taiyar karo** — Recommended size: **1200×500 pixels** (wide banner, 12:5 ratio)
2. **Filename rakho** — niche table dekho, har banner ka exact filename
3. **Yahan upload karo** — `images/banners/` folder mein daal do
4. **Done!** — Page automatically image dikhana shuru kar dega

> ⚠️ Agar koi image upload nahi karoge, to placeholder automatically dikhega.

## 📋 Required Filenames (10 Banner Images)

| # | Filename | Caption | Position in Page |
|---|---|---|---|
| 1 | `banner-1.jpg` | Hottest Call Girls in Hyderabad | After section 3 |
| 2 | `banner-2.jpg` | Genuine VIP Escort Service | After section 6 |
| 3 | `banner-3.jpg` | Independent Hyderabad Beauties | After section 9 |
| 4 | `banner-4.jpg` | Cheap & Affordable Escorts | After section 11 |
| 5 | `banner-5.jpg` | College Girls & Hot Models | After section 15 |
| 6 | `banner-6.jpg` | Sensual Housewives & MILFs | After section 18 |
| 7 | `banner-7.jpg` | Air Hostesses & Models | After section 20 |
| 8 | `banner-8.jpg` | 24/7 On-Demand Booking | After section 23 |
| 9 | `banner-9.jpg` | Romantic GFE Experience | After section 26 |
| 10 | `banner-10.jpg` | Ultimate Erotic Experience | After section 28 |

## 🎨 Image Tips for Best Look

- **Wide ratio:** 12:5 (e.g., 1200×500 or 1440×600 px)
- **Theme:** dark backgrounds work best with the gold gradient overlay
- **Subject placement:** keep important content centered (overlay text appears in center)
- **File size:** compress to ~200KB for fast loading
- **Formats:** `.jpg` (best), `.jpeg`, `.png`, `.webp` — sab chalenge

## 🔄 Auto-Detect Logic

Code khud check karta hai (case-insensitive):
- `banner-1.jpg` → `banner-1.jpeg` → `banner-1.png` → `banner-1.webp`

Iska matlab tum koi bhi format daal sakte ho, bas filename "banner-1" hona chahiye.

## ✏️ Captions / Positions Change Karne Hain?

`swapnavennam.php` mein `$content_banners` array hai — wahaan se sab edit kar sakte ho:

```php
["file" => "banner-1.jpg",
 "caption" => "Your Custom Caption",
 "subtitle" => "Your subtitle",
 "after_section" => 3]
```

`after_section` value badalne se banner dusri jagah dikhega.
