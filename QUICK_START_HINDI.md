# 🚀 Bulk Ads System - हिंदी में Quick Guide

## 🎯 क्या मिलेगा?

एक **complete bulk ad generation system** जो बिना AI API के **humanized content** generate करेगा।

---

## ✨ मुख्य Features

✅ **Template-Based** - कोई AI API नहीं चाहिए  
✅ **100% Humanized** - Natural और unique content  
✅ **Unlimited Ads** - हज़ारों ads एक साथ  
✅ **Smart Phone Handling** - एक number, list, या random  
✅ **Image Management** - Upload और auto-assign  
✅ **Bulk Management** - Activate, delete सब bulk में  

---

## 📁 Files Overview

### 1. Database (1 file)
```
database/bulk_ads_schema.sql
```
- 3 tables create करेगी
- 100+ phrases pre-filled
- 8+ templates pre-filled

### 2. Core Engine (1 file)
```
includes/ContentGenerator.php
```
- Main content generation engine
- Template parser
- Humanization logic

### 3. Admin Files (6 files)

**Generator Interface:**
```
admin/bulk-generator.php          ← यहाँ से start करो
admin/bulk-process.php            ← Backend
```

**Ads Management:**
```
admin/bulk-ads-manager.php        ← Ads देखो/manage करो
admin/bulk-ads-action.php         ← Bulk actions backend
```

**Image Management:**
```
admin/bulk-image-manager.php      ← Images upload करो
admin/bulk-image-handler.php      ← Image processing
```

### 4. Documentation (3 files)
```
BULK_AD_SYSTEM_README.md          ← Complete English guide
FILES_SUMMARY.md                  ← All files list
QUICK_START_HINDI.md              ← Ye file (Hindi guide)
```

### 5. Installer (1 file)
```
install-bulk-system.php           ← One-click installation
```

---

## ⚡ Installation (2 Minute में)

### Step 1: Files Upload करो
सारी files अपनी website के learnworld folder में upload करो।

### Step 2: Installer चलाओ
Browser में खोलो:
```
yourdomain.com/install-bulk-system.php
```

Ye automatically:
- ✅ Database tables बनाएगा
- ✅ Templates और phrases install करेगा
- ✅ Upload folder बनाएगा
- ✅ Permissions check करेगा

### Step 3: Done! 🎉
Ab तुम ready हो ads generate करने के लिए।

---

## 🎮 कैसे Use करें?

### 1️⃣ Bulk Ads Generate करो

**जाओ:** `/admin/bulk-generator.php`

**Form भरो:**
- **Kitne ads:** 10, 50, 100, 1000 (tumhari choice)
- **Category:** Select करो (Escorts, Call Girls, etc.)
- **State/City:** Location select करो
- **Phone Number:**
  - 🔹 **Single Number:** सभी ads में same number
  - 🔹 **Number List:** Multiple numbers paste करो (हर line में एक)
  - 🔹 **Random:** Automatic fake numbers generate होंगे
- **Age Range:** Min-Max set करो (minimum 18)

**Advanced Options:**
- ✅ Auto-publish (तुरंत active)
- ✅ Add delays (ज़्यादा natural lagta hai)

**Preview देखो:**
- "Preview Samples" button click करो
- 3 sample ads देखो पहले

**Generate करो:**
- "Generate Ads Now" click करो
- Wait करो कुछ seconds
- Done! Ads database में save हो गए

---

### 2️⃣ Images Upload करो

**जाओ:** `/admin/bulk-image-manager.php`

**Upload Images:**
- Click करो upload zone पर
- Multiple images select करो (JPG, PNG, WEBP)
- Automatic resize होगा 800x800
- Max 5MB per image

**Auto-Assign:**
- "Auto-Assign Images to Ads" button click करो
- Images automatically distribute होंगे बिना image वाले ads में

---

### 3️⃣ Ads Manage करो

**जाओ:** `/admin/bulk-ads-manager.php`

**Stats देखो:**
- Total ads
- Active/Pending count
- Images के साथ kitne ads

**Filter करो:**
- Category से
- State से
- Status से (Active/Pending)

**Bulk Actions:**
- Checkboxes से multiple ads select करो
- "Activate Selected" - सब active करो
- "Deactivate Selected" - सब deactivate करो
- "Delete Selected" - सब delete करो

**Individual Actions:**
- Single ad view करो
- Single ad delete करो

---

## 🎨 Customize कैसे करें?

### More Templates Add करो

Database में direct insert करो:

```sql
INSERT INTO content_templates (type, content) VALUES
('title', 'VIP {adjective} Girl in {city} - Call Now'),
('description', 'Namaste! Main {name} hoon, {age} saal ki. {contact_info}');
```

### More Phrases Add करो

```sql
INSERT INTO phrase_variations (phrase_group, phrase, weight) VALUES
('adjective', 'Premium', 3),
('adjective', 'Elite', 2),
('female_names', 'Ritu', 3),
('personality', 'Main bahut friendly aur genuine hoon.', 2);
```

**Available Placeholders:**
- `{city}` - City name
- `{age}` - Random age
- `{name}` - Random female name
- `{adjective}` - Random adjective
- `{service_type}` - Escort, Call Girl, etc.
- `{availability}` - Available Now, 24/7, etc.
- `{personality}` - Personality phrases
- `{contact_info}` - Contact phrases

---

## 📊 Example Output

### Generated Title:
```
Beautiful Escort Girl Available in Delhi
VIP Call Girl in Mumbai - 24/7 Available
Gorgeous Service Delhi Available Now
```

### Generated Description:
```
Hello gentlemen! I am Priya, a 24 year old beautiful girl 
providing escort services in Delhi. I am friendly and easy 
to talk with. Available 24/7 for your convenience. 
Call or WhatsApp me now to book your appointment.
```

Har ad **unique** hoga different phrases के combination से!

---

## 🐛 Problems?

### Images upload nahi ho rahi
**Fix:**
```bash
chmod 777 uploads/bulk-images
```

### Database error aa raha hai
**Check karo:**
- `includes/config.php` में correct credentials
- Database में `escorts` table exist karta hai
- SQL file import ho gai hai

### Variations nahi dikh rahe
**Solution:**
- SQL file dobara import karo
- Database में `phrase_variations` table check karo
- Phrases add karo manually if needed

---

## 💡 Pro Tips

### Content Quality ke liye:
1. ✅ Minimum 50+ phrase variations rakho
2. ✅ "Add delays" option enable karo
3. ✅ Preview dekh ke hi generate karo
4. ✅ Mix karo different templates

### Images ke liye:
1. ✅ Variety of images upload karo
2. ✅ High quality use karo (500x500+)
3. ✅ WEBP format best hai (small size)

### Management ke liye:
1. ✅ Pehle pending rakho, review karo, phir activate
2. ✅ Filters use karo location/category se
3. ✅ Old ads regularly cleanup karo

---

## ✅ Testing Checklist

Installation ke baad test karo:

- [ ] 5-10 test ads generate karo
- [ ] Preview dekho quality check kare
- [ ] Ek sample image upload karo
- [ ] Image assign karo test ads ko
- [ ] Site pe dekho ad kaise dikh raha hai
- [ ] Sab theek hai? Ab bulk generate karo!

---

## 📞 Access Links

| Feature | URL |
|---------|-----|
| **Installer** | `/install-bulk-system.php` |
| **Generator** | `/admin/bulk-generator.php` |
| **Image Upload** | `/admin/bulk-image-manager.php` |
| **Manage Ads** | `/admin/bulk-ads-manager.php` |

---

## 🎯 Workflow Summary

```
1. Install karo → install-bulk-system.php
2. Ads generate karo → bulk-generator.php
3. Images upload karo → bulk-image-manager.php
4. Images assign karo → Auto-Assign button
5. Manage karo → bulk-ads-manager.php
6. Review & Activate karo
7. Repeat! 🔄
```

---

## 🔥 Power Features

### Humanization System:
- 15+ adjectives
- 8+ title templates
- 5+ description templates
- 50+ phrase variations
- 15+ female names
- Millions of combinations possible!

### Smart Phone System:
- Single number mode
- List rotation (agar multiple numbers hai)
- Random generation (testing ke liye)

### Bulk Operations:
- Generate 1000 ads in minutes
- Bulk activate/deactivate
- Bulk delete
- Filter and manage easily

---

## 🎉 Ready!

Tumhara **complete bulk ad generation system** ready hai!

**Ab kya karna hai:**
1. ✅ Installer chalao
2. ✅ 10 test ads banao
3. ✅ Quality check karo
4. ✅ Images upload karo
5. ✅ Full blast karo - 100s of ads! 🚀

---

## 📚 Detailed Guide

Agar aur detail chahiye English mein:
- Read: `BULK_AD_SYSTEM_README.md`
- Files list: `FILES_SUMMARY.md`

---

## 💪 System Power

- **No AI API needed** - Pure template-based
- **No Excel needed** - Direct form se generate
- **Unlimited ads** - Jitne chahiye utne banao
- **100% Humanized** - Natural content
- **Easy to use** - Simple interface
- **Fast** - 100 ads in seconds!

---

*Enjoy karo aur thousands of ads banao! 🎉*

*Questions? Documentation check karo ya error logs dekho browser console mein.*

---

**All the best! 🚀**
