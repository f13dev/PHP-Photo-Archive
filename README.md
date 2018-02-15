# PHP Photo Archive
A simple photo archive and gallery tool for web servers. Designed with thought for desktop and mobile users from the ground up.

Photo Archive does not require any form of database. Simply create folders; drag and drop image to create your archive.

1. [Live demo](#live-demo)
1. [Requirements](#requirements)
1. [Installing](#installing)
1. [Using](#using)
    1. [Creating a gallery](#creating-a-gallery)
    1. [Adding images and videos](#adding-images-and-videos)
    1. [Creating a notes file](#creating-a-notes-file)
    1. [Settings](#settings)
    1. [Managing archive maintenance via CRON](#managing-archive-maintenance-via-cron)
1. [License](#license)
1. [Credits](#credits)

## Live demo
[View the live demo](https://f13dev.com/PHP-Photo-Archive)

## Requirements
* Apache/Nginx/Other web server
* PHP v5.x, PHP 7.x
* FTP/sFTP/Other file upload access
* Imagemagick (if thumbnails are required to be generated), PHP-GD can be used, but doesn't support video thumbnails.

## Installing
Due to the way PHP Photo Archive is designed installation can be as simple as connecting to your web server via file access and uploading the release.

If you prefer to you can always connect to your web server via SSH and use the following command to clone the repository.

```
git clone https://github.com/f13dev/PHP-Photo-Archive /path/to/install/to
```

You will need to ensure that the ```archive/images```, ```archive/mid``` and ```archive/thumbs``` directories and the ```cron.log``` file are writable.

## Using

### Creating a gallery
Galleries are created with a simple folder structure of directories and their content. No limits are imposed with regards to the depth of the directory structure.

By default the archive root is contained in the following location:
    script root/archive/images/
Any directories and/or files within this location can form your archive.

### Adding images and videos
At present PHP Photo Archive accepts the following image formats:

Format | Chrome | Firefox | Internet Explorer | Opera | Safari
-------|--------|---------|-------------------|-------|-------
GIF  | YES | YES | YES | YES | YES
JPG | YES | YES | YES | YES | YES
PNG | YES | YES | YES | YES | YES
TIFF | NO | NO | YES | NO | YES

And the following video formats

Format | Chrome | Firefox | Internet Explorer | Opera | Safari
-------|--------|---------|-------------------|-------|-------
MP4 | YES | YES | YES | YES (v25+) | YES
OGG | YES | YES | NO | YES | NO
WEBM | YES | YES | NO | YES | NO

To add your desired image and video content:
* Connect to your web server via your chosen file manager
* Locate/or create the desired gallery directory
* Upload your desired content

After uploading your content, thumbnails will not have been created. Until thumbnails are created browsing may be slow, depending on the size of your images and the connection speed.

### Creating a notes file
A notes file is a plain text file which resides in a gallery directory. A link to this file will be placed on each page of the given directory.

Notes files have been included to allow adding information about the contents of a gallery; such as the date, location or any other desired information.

Create a standard txt file using any plain text editor and upload it to the directory of the desired gallery.

### Settings
To simplify setting up your gallery, all major settings are defined in a single file located at ```inc/settings.php```

#### Set the copyright copyright holder
```php
define('COPYRIGHT_HOLDER', 'your name');
```

This will alter the copyright text shown on the footer of the gallery.

#### Set the site language
```php
define('SITE_LANG', 'en');
```

This will set the site language file to load the the content of ```inc/lang/en.lang.php```.

#### Set the site title
```php
define('SITE_TITLE', 'My site title');
```

This will set the site title as shown at the top of the gallery.

#### Setting the size of the thumbnails
```php
define('THUMB_MAX_WIDTH', 150);
define('THUMB_MAX_HEIGHT', 150);
```
This will change the maximum dimensions of the thumbnails created by cron.

#### Enable reduced images for previews
```php
define('ENABLE_MID_IMAGES', true);
```

When set to true, cron will generate mid sized images for previewing. This uses more hard drive space but can drastically reduce page loading times. When set to false, less hard drive space is used but page loading times will be longer.

#### Setting the size of reduced size images
```php
define('IMG_MAX_WIDTH', 1920);
define('IMG_MAX_HEIGHT', 1080);
```

This will change the maximum dimensions of the reduced size images created by cron. If ```ENABLE_MID_IMAGES``` is set to false, these details are ignored.

#### Setting the archive folders
```php
define('ARCHIVE_MAIN', 'archive/images/');
define('ARCHIVE_MID', 'archive/mid/');
define('ARCHIVE_THUMBS', 'archive/thumbs/');
```

The directory shown here is the relative path from the gallery script. If ```ENABLE_MID_IMAGES``` is set to false, ```ARCHIVE_MID``` will be ignored.

#### Create thumbs on page load
```php
define('CREATE_THUMBS_ON_LOAD', true);
```

If this is set to true then thumbs will be created as you brows the gallery.

At present this function does not work.

#### Set how many images to show on each page
```php
define('FILES_PER_PAGE', 50);
```

This will show a maximum of 50 images on each page, a gallery with more than 50 images will be split over multiple pages.

#### Set the cron log file
```php
define('CRON_LOG', cron.log);
```

This sets the filename for the log file used by cron relative to the gallery script.

#### Enable exif editing
```php
define('ENABLE_EDIT',false);
```

Setting this option to true enables visitors to update the exif comment tag to add a description to images. At present exif editing is in experimental phases and may not work in all instances.

Things to consider:
* Setting to true allows anybody to edit the exif data (password protection may be added at a later date), it is therefor recommended to only enable this option on password protected personal servers.
* Images must be under the ownership of 'www-data', or the appropriate group for exif editing to work.
* The imagick PHP extension must be installed and activated for this to work.
* It may be easier and more secure to edit the exif comment tag on your computer before uploading.

### Managing archive maintenance via CRON
#### How to write a CRON command
In order to enable automatic maintenance via CRON you will need to create a cron job to run at your specified frequency.

Cron jobs consist of 2 main parts; the first being the frequency that the job should run at split into 5 distinct sections: minute, hour, day of the month, month of the year, day of the week. Using an astrix (*) determines that it will run for every instance of that frequency.

For example ```0 1 * * *``` will run the cron job on the minute 0 of the first hour on every day of the month, every month of the year and every day of the week. i.e the script will run at 1am every day.

The second part of the cron job is the command it should run. As the PHP script should run from the directory it resides in we would first need to change the directory; if the script resides in the directory '/var/www/html/gallery' then we would use:

```
CD /var/www/html/gallery
```

Now we are in the correct gallery, we can run the script via PHP-CLI:

```
/usr/bin/php /var/www/html/gallery/cron.php
```

So to finalise this command, assuming that the script is in the directory '/var/www/html/gallery' and we want to run the script at 1am every day, our command would be:

```
0 1 * * * CD /var/www/html/gallery && /usr/bin/php /var/www/html/gallery/cron.php
```

#### Adding cron.php to the crontab
There are many ways to add a cron job depending on the way your server is set up, if you are on a shared hosing plan then you will most likely have access to create cron jobs via the control panel (i.e. Plesk, cPanel etc...).

If you have SSH access to a Linux based server the crontab can be edited with the command:
```crontab -e```
This will open a basic text editor where you can type the cron command to run the script. To save the cron job press ```[ctrl] + o``` followed by ```[enter]``` and finally ```[ctrl] + x``` to exit the text editor
## License
Photo archive - [MIT License](LICENSE)

## Credits
Colorbox - [MIT License](inc/colorbox/LICENSE) by [Jacklmoore](https://github.com/jackmoore)
