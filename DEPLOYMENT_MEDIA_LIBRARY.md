# Media Library Deployment Guide

## Overview
This project has been configured to store media files directly in the `public/uploads` directory instead of using symbolic links. This is necessary for servers that don't support symlinks.

## Changes Made

### 1. New Disk Configuration
Added a new `media` disk in `config/filesystems.php`:
```php
'media' => [
    'driver' => 'local',
    'root' => public_path('uploads'),
    'url' => env('APP_URL').'/uploads',
    'visibility' => 'public',
    'throw' => false,
],
```

### 2. Media Library Configuration
Updated `config/media-library.php`:
- `disk_name`: Changed from `public` to `media`
- `url_generator`: Custom `PublicUrlGenerator` class
- `path_generator`: Custom `PublicPathGenerator` class

### 3. Custom Classes Created
- `app/Support/MediaLibrary/PublicUrlGenerator.php` - Generates URLs for media files
- `app/Support/MediaLibrary/PublicPathGenerator.php` - Organizes file structure

## File Structure
Media files will now be stored in:
```
public/uploads/
├── logo/           # Partner logos
│   ├── 1/         # Media ID 1
│   │   ├── file.jpg
│   │   └── conversions/
│   └── 2/         # Media ID 2
├── main_image/     # About Us main images
├── platform_images/ # About Us platform images
├── goal_images/    # About Us goal images
├── banner_image/   # FAQ/Terms banners
└── social_media/   # Social media logos
```

## Deployment Steps

### 1. Upload Code
Upload all the updated files to your server.

### 2. Create Uploads Directory
```bash
mkdir -p public/uploads
chmod 755 public/uploads
```

### 3. Set Permissions
Ensure the web server can write to the uploads directory:
```bash
chown -R www-data:www-data public/uploads  # For Apache/Nginx
# OR
chmod -R 775 public/uploads  # Alternative permission method
```

### 4. Clear Cache
```bash
php artisan optimize:clear
```

### 5. Test Upload
Try uploading a new image through the admin panel to verify the configuration works.

## Migration from Old Storage (If Applicable)

If you have existing media files in the old storage structure, you can migrate them:

### Option 1: Manual Migration
1. Copy files from `storage/app/public/` to `public/uploads/`
2. Maintain the same directory structure
3. Update the database if needed

### Option 2: Automated Migration (Recommended)
Run this command to migrate existing files:
```bash
php artisan media:regenerate
```

## Environment Variables
No new environment variables are required. The configuration uses the existing `APP_URL` setting.

## Troubleshooting

### Images Not Displaying
1. Check if `public/uploads` directory exists and is writable
2. Verify file permissions (755 for directories, 644 for files)
3. Check web server configuration allows access to `/uploads` path

### Upload Errors
1. Ensure `public/uploads` directory is writable by web server
2. Check PHP upload limits in `php.ini`
3. Verify disk space availability

### URL Generation Issues
1. Clear application cache: `php artisan optimize:clear`
2. Check if custom classes are properly autoloaded
3. Verify `APP_URL` is set correctly in `.env`

## Benefits of This Approach

1. **No Symlinks Required**: Works on servers that don't support symbolic links
2. **Direct Access**: Files are directly accessible via web URLs
3. **Better Performance**: No symlink resolution overhead
4. **Easier Backup**: All media files are in one public directory
5. **CDN Friendly**: Easy to configure CDN for the uploads directory

## Security Considerations

1. **File Validation**: Ensure only allowed file types can be uploaded
2. **Access Control**: Consider implementing access control for sensitive media
3. **Virus Scanning**: Implement virus scanning for uploaded files in production
4. **File Size Limits**: Configure appropriate file size limits in PHP and application

## Support
If you encounter any issues, check the Laravel logs in `storage/logs/` and Media Library logs if enabled.
