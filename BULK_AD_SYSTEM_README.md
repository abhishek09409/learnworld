# 🚀 Bulk Ad Generation System - Complete Guide

## 📋 Overview

Complete bulk ad generation system with **humanized, template-based content** for your escort classified site. Generate hundreds of unique ads in seconds without using AI APIs!

---

## ✨ Features

### 🎯 Core Features
- ✅ **Template-Based Generation** - No AI API needed
- ✅ **100% Humanized Content** - Natural, unique variations
- ✅ **Unlimited Combinations** - Thousands of unique ads possible
- ✅ **Smart Phone Handling** - Single number, list rotation, or random
- ✅ **Bulk Image Management** - Upload & auto-assign images
- ✅ **Batch Tracking** - Monitor generation history
- ✅ **Preview Mode** - See samples before generating
- ✅ **Random Delays** - Natural posting patterns
- ✅ **Bulk Management** - Activate, deactivate, delete in bulk

### 📊 Content Variations
- **15+ Adjectives** - Beautiful, Gorgeous, Stunning, etc.
- **8+ Title Templates** - Multiple formats for variety
- **5+ Description Templates** - Different writing styles
- **50+ Phrase Variations** - Personality, availability, services
- **15+ Female Names** - Randomized for each ad
- **Age Ranges** - Customizable min/max (18+)

---

## 📁 File Structure

```
learnworld/
│
├── admin/
│   ├── bulk-generator.php          # Main generation interface
│   ├── bulk-process.php             # Backend processor
│   ├── bulk-ads-manager.php         # Ads management interface
│   ├── bulk-ads-action.php          # Bulk actions handler
│   ├── bulk-image-manager.php       # Image upload/management
│   └── bulk-image-handler.php       # Image processing backend
│
├── includes/
│   └── ContentGenerator.php         # Core generation engine
│
├── database/
│   └── bulk_ads_schema.sql          # Database schema
│
└── uploads/
    └── bulk-images/                 # Image storage (auto-created)
```

---

## 🔧 Installation Steps

### Step 1: Import Database Schema

Run the SQL file to create necessary tables:

```bash
mysql -u your_username -p your_database < database/bulk_ads_schema.sql
```

Or manually import via phpMyAdmin:
1. Open phpMyAdmin
2. Select your database
3. Go to Import tab
4. Choose `bulk_ads_schema.sql`
5. Click Go

**Tables Created:**
- `content_templates` - Title and description templates
- `phrase_variations` - Humanization phrases (100+ pre-filled)
- `bulk_batches` - Generation history tracking

### Step 2: Set Permissions

Ensure upload directory is writable:

```bash
mkdir -p uploads/bulk-images
chmod 777 uploads/bulk-images
```

### Step 3: Verify Database Connection

Check that `includes/config.php` has correct credentials:

```php
$conn = new mysqli("localhost", "username", "password", "database");
```

### Step 4: Access Admin Panel

Navigate to:
```
yourdomain.com/admin/bulk-generator.php
```

---

## 🎮 How to Use

### Generate Bulk Ads

1. **Go to:** `admin/bulk-generator.php`

2. **Fill Form:**
   - **Number of Ads:** 1-1000
   - **Category:** Select from your categories
   - **State/City:** Choose location
   - **Phone Mode:**
     - *Single Number:* All ads use same number
     - *Number List:* Paste multiple numbers (one per line)
     - *Random:* Auto-generate fake numbers
   - **Age Range:** Min-Max (18+)

3. **Advanced Options:**
   - ✅ Auto-publish (set as active immediately)
   - ✅ Add delays (more natural, prevents spam detection)

4. **Preview:**
   - Click "Preview Samples" to see 3 sample ads
   - Check content quality before generating

5. **Generate:**
   - Click "Generate Ads Now"
   - Wait for completion
   - Ads are inserted into database

### Upload & Assign Images

1. **Go to:** `admin/bulk-image-manager.php`

2. **Upload Images:**
   - Click upload zone
   - Select multiple images (JPG, PNG, WEBP)
   - Images are auto-resized to 800x800
   - Max 5MB per image

3. **Auto-Assign:**
   - Click "Auto-Assign Images to Ads"
   - Images are distributed to ads without images
   - Random distribution for variety

### Manage Generated Ads

1. **Go to:** `admin/bulk-ads-manager.php`

2. **View Statistics:**
   - Total ads
   - Active/Pending counts
   - Ads with images

3. **Filter Ads:**
   - By category
   - By state
   - By status

4. **Bulk Actions:**
   - Select multiple ads (checkbox)
   - Activate selected
   - Deactivate selected
   - Delete selected

5. **Individual Actions:**
   - View ad on site
   - Delete single ad

---

## 🎨 Customization

### Add More Templates

Edit database table `content_templates`:

```sql
INSERT INTO content_templates (type, content) VALUES
('title', 'Your {adjective} {service_type} in {city}'),
('description', 'Hi! I am {name}, {age} years old. {contact_info}');
```

**Available Placeholders:**
- `{city}` - City name
- `{age}` - Random age
- `{name}` - Random female name
- `{adjective}` - Random adjective
- `{service_type}` - Escort, Call Girl, etc.
- `{availability}` - Available Now, 24/7, etc.
- `{personality}` - Personality phrases
- `{physical_desc}` - Physical descriptions
- `{service_desc}` - Service descriptions
- `{contact_info}` - Contact phrases

### Add More Phrases

Edit database table `phrase_variations`:

```sql
INSERT INTO phrase_variations (phrase_group, phrase, weight) VALUES
('adjective', 'Classy', 3),
('female_names', 'Aisha', 2),
('personality', 'I am very friendly and genuine.', 2);
```

**Phrase Groups:**
- `adjective`
- `female_names`
- `service_type`
- `availability`
- `availability_desc`
- `personality`
- `physical_desc`
- `service_desc`
- `contact_info`

**Weight:** Higher weight = more frequency (1-5 recommended)

### Customize UI Colors

Edit CSS in admin files:

```css
/* Main gradient color */
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);

/* Change to your brand colors */
background: linear-gradient(135deg, #ff2d75 0%, #ff5fa2 100%);
```

---

## 📊 Example Output

### Sample Generated Title:
```
Beautiful Escort Girl Available in Delhi
Gorgeous Call Girl in Mumbai - Available Now
VIP Service Delhi 24/7 Available
```

### Sample Generated Description:
```
Hello gentlemen! I am Priya, a 24 year old beautiful girl providing 
escort services in Delhi. I am friendly and easy to talk with. 
Available 24/7 for your convenience. Call or WhatsApp me now to 
book your appointment.
```

---

## 🔒 Security Notes

1. **Admin Access Only:**
   - All bulk files check `$_SESSION['user_id']`
   - Redirect to login if not authenticated

2. **SQL Injection Protection:**
   - All inputs are escaped with `real_escape_string()`
   - IDs are validated with `intval()`

3. **File Upload Security:**
   - Only JPG, PNG, WEBP allowed
   - File type verified with `finfo`
   - Max 5MB size limit
   - Unique filenames prevent overwrites

4. **Batch Tracking:**
   - All generations logged in `bulk_batches`
   - Timestamp and user ID recorded

---

## 🐛 Troubleshooting

### Problem: Images not uploading
**Solution:**
```bash
chmod 777 uploads/bulk-images
```

### Problem: Database error on generation
**Solution:**
- Check `escorts` table exists
- Verify column names match your schema
- Check `includes/config.php` connection

### Problem: No templates/phrases loaded
**Solution:**
- Import `bulk_ads_schema.sql` again
- Check tables: `content_templates`, `phrase_variations`

### Problem: Ads not showing variations
**Solution:**
- Add more phrases to database
- Increase phrase weights
- Check ContentGenerator.php cache loading

---

## 📈 Performance Tips

1. **Large Batches:**
   - Enable "Add delays" option
   - Generate in batches of 100-200
   - Upload images separately

2. **Database Optimization:**
   - Add indexes on `category_slug`, `state_id`, `city_id`
   - Regular cleanup of old pending ads

3. **Image Optimization:**
   - Pre-resize images before upload
   - Use WEBP format for smaller size
   - Clean unused images periodically

---

## 🎯 Best Practices

### Content Quality:
- ✅ Use 50+ phrase variations for uniqueness
- ✅ Enable random delays for natural posting
- ✅ Mix different title/description templates
- ✅ Review preview before bulk generation

### Image Management:
- ✅ Upload variety of images (different backgrounds, poses)
- ✅ Use high-quality images (500x500 minimum)
- ✅ Assign images after generation for better distribution

### Ads Management:
- ✅ Set as pending first, review, then activate
- ✅ Use filters to manage by location/category
- ✅ Regularly cleanup duplicate/low-quality ads
- ✅ Monitor batch history for tracking

---

## 📞 Support

For issues or questions:
1. Check troubleshooting section above
2. Verify all installation steps completed
3. Review error logs in browser console
4. Check database for data integrity

---

## 🎉 Quick Start Checklist

- [ ] Import database schema
- [ ] Set upload directory permissions
- [ ] Verify config.php connection
- [ ] Add custom templates (optional)
- [ ] Add custom phrases (optional)
- [ ] Test with 3-5 ads first
- [ ] Upload sample images
- [ ] Generate bulk ads
- [ ] Assign images
- [ ] Review and activate

---

## 🚀 Ready to Go!

Your bulk ad generation system is now complete. Generate hundreds of unique, humanized ads in seconds!

**Start Here:** `/admin/bulk-generator.php`

---

*Built with ❤️ for high-volume classified sites*
