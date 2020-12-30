# Note about upgrading

"in-place upgrade" refers to this general procedure:

1. Backup your Jirafeau installation!
2. Block access to Jirafeau
3. Checkout the new version with Git using the [tagged release](https://gitlab.com/mojo42/Jirafeau/tags)
   * If you have installed Jirafeau just by uploading files on your server, you can download the desired version, overwrite/remove all files and chown/chmod files if needed. Keep a backup of your local configuration file tough.
4. With you browser, go to your Jirafeau root page
5. Follow the installation wizard, it should propose you the same data folder or even update automatically
6. Check your ```/lib/config.local.php``` and compare it with the ```/lib/config.original.php``` to see if new configuration items are available

# version 4.3.0

- Fix various docker errors
- Fix various upload errors
- Add composer (useful for CI)
- Code cleaning
- Add option 'store_uploader_ip' to avoid uploaders ip logging
- Upgrade from 4.2.0: in-place upgrade

# version 4.2.0

- New file_hash option to eventually speed-up file identification process
- one_time_download is now optional
- Litespeed workaround for large files
- Admin interface can compute data folder size
- REUSE compliance test
- multiple docker features: mcrypt support, daily cleanup, unprivilidged user
- Add upload password capability in script options
- Various bugfixes around retries and error management
- Automatically lower chunk size sent to server refusing large chunks
- Romanian lang support and other various lang support
- Upgrade from 4.1.1: in-place upgrade

# Version 4.1.1

- Fix lang sanity check
- Upgrade from 4.1.0: in-place upgrade

# Version 4.1.0

- Fix upload password and allowed ip (#201)
- Code refactorisation of IP checking
- Fix expiration dates
- Add better support for Accept-Language
- Cosmetic fixes
- More languages supported and language fixes
- Upgrade from 4.0.0: in-place upgrade

# Version 4.0.0

- Removed plain-text password support for admin auth (breaking change).
- Default folder sub-division to 8 characters (breaking change).
- New option `upload_ip_nopassword` to allow a list of IP to access Jirafeau without password
- Bugfix with LibreJS
- Other minor bug fixes
- More languages supported

## Upgrade from 3.4.1 to 4.0.0

You may have to change your administrator password in your config file as admin password are only stored using sha256 (SHA2).
To do so, edit `lib/config.local.php` and update `admin_password` option using `echo -n MyNewPassw0rd | sha256sum` command.

Subfolder division changed in Jirafeau storage. You can either start from a fresh `var-` folder or you need to migrate your data.

In order to migrate your existing data:
1. Be sure to have a working backup of your Jirafeau instance and/or the rest of your hosting before any operation
2. Go to `var-` folder
3. Be sure you have read and write permissions on files and folders with your current user
4. Run the following commands:
```bash
# Migrate files folder
find files -type f ! -name "*_count" | while read f; do bn="$(basename "$f")"; dst="files/${bn:0:8}/${bn:8:8}/${bn:16:8}/${bn:24:8}/"; mkdir -p "$dst"; mv "$f" "$dst" ; mv "${f}_count" "$dst"; done; find files -maxdepth 1 -type d -iname "?" -exec rm -rf {} \;
# Migrate links folder
find links -type f | while read link; do bn="$(basename "$link")"; mkdir "links/$bn"; mv "$link" "links/$bn/"; done; find links -maxdepth 1 -type d -iname "?" -exec rm -rf {} \;
```

# Version 3.4.1

- Security fixes, thanks [Bishopfox Team](https://www.bishopfox.com/)
- Translation fixes
- Docker fix
- Advertise javascript license for LibreJS compatibility
- other minor fixes
- Upgrade from 3.4.0: in-place upgrade

# Version 3.4.0

- Add encryption support in bash script
- Refactoring of lang system for simpler management
- Removed installation step asking for language
- Merged weblate contributions
- Fixed some spelling issues
- Upgrade from 3.3.0 : in-place upgrade

# Version 3.3.0

- Added Docker Support
- Added a copy button next to links to copy URLs in clipboard
- Now use a delete page to confirm file deletion (#136)
- Fixed object ProgressEvent Error (#127)
- Added configuration tips for web servers
- More translations
- Style fixes
- Removed useless alias API support (some old toy)
- Upgrade from 3.2.1 : in-place upgrade

# Version 3.2.1

- fix download view after an upload
- Upgrade from 3.2.0 : in-place upgrade

# Version 3.2.0

- Update translations from Update translations from weblate
- Better style
- Fix regression on admin password setting
- Upgrade from 3.1.0 : in-place upgrade

# Version 3.1.0

- Fix regression on user authentication (see #113)
- Some cosmetic change
- Upgrade from 3.0.0 : in-place upgrade

# Version 3.0.0

- Remove XHTML doctype, support HTML5 only → breaking change for older browsers
- Remove redundant code
- Remove baseurl usage and set absolute links instead, which for example fixes SSL issues
- Extend contribution guide
- Switch to PSR-2 code style (fix line endings, indentations, whitespaces, etc)
- Declare system requirements
- Catch API errors in upload form
- Allow clients to upload files depending on IP or password
- Set UTC as timezone to prevent date/time issues
- Show readable date & time information
- Fix UI glitches in admin panel and upload form
- Upgrade from 2.0.0 : in-place upgrade

# Version 2.0.0

- Various documentation improvements
- Simplify automatic generation of local configuration file
- Set a custom title
- Bash Script: Enhanced help, show version, return link to web view as well
- »Terms of Service« refactored - Enable admin to overwrite the ToS, without changing existing source code → breaking, see upgrade notes

## Upgrade from version 1.2.0 to 2.0.0

The "Terms of Service" text file changed.
To reuse a custom version of your ToS, move your ```/tos_text.php``` file to ```/lib/tos.local.txt``` and remove all HTML und PHP Tags, leaving a regular text file.

# Version 1.2.0

- Link on API page to generate bash script
- More informative error codes for API
- Security Fix: Prevent authentication bypass for admin interface
- CLI script to remove expired files automatically with a cronjob
- SHA-256 hash the admin password
- New theme "elegantish"
- Fix for JavaScript MIME-Type, prevents blocking the resource on some servers
- Show download link for a file in admin interface
- Default time for expiration (set to 'month' by default)
- New expiration time: 'quarter'
- A lof of translation contributions
- Code cleanups
- Upgrade from 1.1: in-place upgrade

# Version 1.1

- New skins
- Add optional server side encryption
- Unlimited file size upload using HTML5 file API
- Show speed and estimated time during upload
- A lot of fixes
- A lot of new langages
- Small API to upload files
- Limit access to Jirafeau using IP, mask, passwords
- Manage (some) proxy headers
- Configure your maximal upload size
- Configure file's lifetime durations
- Preview URL
- Get Jirafeau's version in admin interface

### From version 1.0 to 1.1

- Download URL changed. Add a rewrite rule in your web server configuration to rename ```file.php``` to ```f.php``` to make older, still existing links work again-
- The default theme changed. Optionally change the theme in ```lib/config.local.php``` to "courgette"

## Version 1.0

The very first version of Jirafeau after the fork of Jyraphe.

- Security fix
- Keep uploader's ip
- Delete link for each upload
- No more clear text password storage
- Simple langage support
- Add an admin interface
- New Design
- Add term of use
- New path system to manage large number of files
- New option to show a page at download time
- Add option to activate or not preview mode
