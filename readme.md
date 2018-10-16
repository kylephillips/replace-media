# Replace Media for WordPress


## Overview

This WordPress plugin enables a "Replacement" button for media files within the media library. Unlike other plugins, this allows complete override of files.

Existing plugins do exist that allow for the replacement of attached files, but this does not address external URLs that point to the file. Typically, they will upload the new file and perform a search/replace within the database to direct links to that new file.

This plugin renames the new upload's file name to match that of the original file. The original file is removed.

For example, a PDF may need to be completely overwritten on occasion without effecting existing internal and external links. Rather than manually connecting via FTP and replacing the file, this plugin enables users with upload capabilities to do so within the media library.

#### Important Note
Replacing files will **completely** override existing files. Make backups accordingly.

#### Media Support
Images are not currently supported. This plugin is currently primarily geared for replacement of PDFs, Word Documents, Excel Documents, Text Documents, and other non-image file types.

#### Usage
Within the media library or attachment modal, a "Replacement" button will be added to non-image attachments. Click the button to load the replacement form.

![Screenshot](https://raw.githubusercontent.com/kylephillips/replace-media/master/screenshots/screenshot-1.png)

Upload the replacement document and click the "Replace" button. Selecting "Cancel Replacement" will close the form and return to the default attachment details screen.

**Note:** Replacement files must match the same type as the original file type. A PDF must be replaced by another PDF, etc…
![Screenshot](https://raw.githubusercontent.com/kylephillips/replace-media/master/screenshots/screenshot-1.png)
