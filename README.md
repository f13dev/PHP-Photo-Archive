# PHP Photo Archive
A simple photo archive and gallery tool for web servers. Designed with thought for desktop and mobile users from the ground up.

Photo Archive does not require any form of database. Simply create folders; drag and drop image to create your archive.

1. [Requirements](#requirements)
1. [Installing](#installing)
1. [Using](#using)
    1. [Creating a gallery](#creating-a-gallery)
    1. [Adding images and videos](#adding-images-and-videos)
    1. [Creating a notes file](#creating-a-notes-file)
    1. [Settings](#settings)
    1. [Managing archive maintenance via CRON](managing-archive-maintenance-via-cron)
1. [License](#license)

## Requirements
* Apache/Nginx/Other web server
* PHP v? (Pending testing)
* FTP/sFTP/Other file upload access

## Installing
Due to the way PHP Photo Archive is designed installation can be as simple as connecting to your web server via file access and uploading the release.

If you prefer to you can always connect to your web server via SSH and use the following command to clone the repository.

    git clone https://github.com/f13dev/PHP-Photo-Archive /path/to/install/to

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
TIFF | YES | YES | YES | YES | YES

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

### Managing archive maintenance via CRON

## License
[BSD 3-Clause License](LICENSE)
