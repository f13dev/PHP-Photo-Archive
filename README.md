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

### Creating a notes file

### Settings

## License
