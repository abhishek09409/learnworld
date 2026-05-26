# 📸 Call Girl Profile Images

Ye folder gallery section ke har profile ki image rakhne ke liye hai.

## How to Add Images (Step-by-Step)

1. **Image taiyar karo** — Recommended size: **600×800 pixels** (3:4 ratio, portrait)
2. **Filename rakho** — niche table dekho, har profile ka exact filename
3. **Yahan upload karo** — `images/girls/` folder mein daal do
4. **Done!** — Page automatically image dikhana shuru kar dega

> ⚠️ Agar koi image upload nahi karoge, to placeholder automatically dikhega.
> Code khud check karta hai file exists hai ya nahi.

## 📋 Required Filenames

| # | Profile Name | Filename | Category |
|---|---|---|---|
| 1 | Priya Sharma | `priya.jpg` | College Girl |
| 2 | Anushka Rao | `anushka.jpg` | Housewife |
| 3 | Kavya Reddy | `kavya.jpg` | Air Hostess |
| 4 | Riya Mehta | `riya.jpg` | Fashion Model |
| 5 | Tanya Singh | `tanya.jpg` | VIP Escort |
| 6 | Sneha Iyer | `sneha.jpg` | Russian |
| 7 | Ananya Das | `ananya.jpg` | College Girl |
| 8 | Pooja Verma | `pooja.jpg` | Actress |
| 9 | Naina Khan | `naina.jpg` | Hot MILF |
| 10 | Divya Joshi | `divya.jpg` | Independent |
| 11 | Aarohi Sen | `aarohi.jpg` | Insta Influencer |
| 12 | Meera Kapoor | `meera.jpg` | Premium Model |

## 🔄 Supported Formats

Code automatic in formats ko detect karta hai (case-insensitive):

- `.jpg` ✅ (recommended)
- `.jpeg`
- `.png`
- `.webp`

Matlab agar tumhare paas `priya.png` hai toh bhi chal jayega — bas filename "priya" hona chahiye.

## ✏️ Names / Categories Change Karne Hain?

`swapnavennam.php` file mein top par `$gallery` array hai — wahan se name, category, age, rating, tags edit kar sakte ho.

Agar koi naya profile add karna hai, ya filename change karna hai:

```php
$gallery = [
    ["name" => "Your Name",   "image" => "yourimage.jpg", ...],
    ...
];
```

## 💡 Tips for Best Look

- **Aspect ratio: 3:4 portrait** (jaise mobile photo)
- High quality images use karo (min 600×800)
- Face/body clear ho, dark background prefer karo theme ke saath match karne ke liye
- Compress karke upload karo (JPG ~150KB max) for fast loading
