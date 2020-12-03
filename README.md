# Jirafeau

![Build Status](https://img.shields.io/gitlab/pipeline/mojo42/Jirafeau/master.svg)
![Made With](https://img.shields.io/badge/made_with-php-blue.svg)
![License](https://img.shields.io/badge/license-agpl--3.0-blue.svg)
![Contribution](https://img.shields.io/badge/contributions_welcome-brightgreen.svg?labelColor=brightgreen)

Welcome to the official Jirafeau project, an [Open-Source software](https://en.wikipedia.org/wiki/Open-source_software).

Jirafeau is a "one-click-filesharing": Select your file, upload, share a link. That's it.

See [jirafeau.net](https://jirafeau.net/) for a demo.

![Screenshot1](http://i.imgur.com/TPjh48P.png)

## Main features

- One upload → One download link & one delete link
- Send any large files (thanks to the HTML5 file API → PHP post_max_size limit not relevant)
- Shows progression: speed, percentage and remaining upload time
- Preview content in browser (if possible)
- Optional password protection (for uploading or downloading)
- Set expiration time for downloads
- Option to self-destruct after first download
- Shortened URLs using base 64 encoding
- Maximal upload size configurable
- NO database, only use basic PHP
- Simple language support with a lot of langages (help us on [weblate](https://hosted.weblate.org/engage/jirafeau/)!)
- File level [Deduplication](http://en.wikipedia.org/wiki/Data_deduplication) for storage optimization (does store duplicate files only once, but generate multiple links)
- Optional data encryption
- Small administration interface
- CLI script to remove expired files automatically with a cronjob
- Basic, adaptable »Terms Of Service« page
- Basic API
- Bash script to upload files via command line
- Themes

Jirafeau is a fork of the original project [Jyraphe](http://home.gna.org/jyraphe/) based on the 0.5 (stable version) with a **lot** of modifications.

As it's original project, Jirafeau is made in the [KISS](http://en.wikipedia.org/wiki/KISS_principle) way (Keep It Simple, Stupid).

Jirafeau project won't evolve to a file manager and will focus to keep a very few dependencies.

## Screenshots

- [Installation - Step 1](http://i.imgur.com/hmpT1eN.jpg)
- [Installation - Step 2](http://i.imgur.com/2e0UGKE.jpg)
- [Installation - Step 3](http://i.imgur.com/ofAjLXh.jpg)
- [Installation - Step 4](http://i.imgur.com/WXqnfqJ.jpg)
- [Upload - Step 1](http://i.imgur.com/SBmSwzJ.jpg)
- [Upload - Step 2](http://i.imgur.com/wzPkb1Z.jpg)
- [Upload - Progress](http://i.imgur.com/i6n95kv.jpg)
- [Upload - Confirmation page](http://i.imgur.com/P2oS1MY.jpg)
- [Admin Interface](http://i.imgur.com/nTdsVzn.png)

## Installation

This shows how to install Jirafeau by your own, it's quite simple but you can
also use a [docker image](https://hub.docker.com/r/mojo42/jirafeau/) or build
it yourself. Check [docker folder](docker/README.md) for more informations.

System requirements:
- PHP >= 5.6
- Optional, but recommended: Git >= 2.7
- No database required, no mail required

Installation steps:
- Clone the [repository](https://gitlab.com/mojo42/Jirafeau/) or download the latest [release](https://gitlab.com/mojo42/Jirafeau/tags) from GitLab onto your webserver
- Set owner & group according to your webserver
- A) Setup with the installation wizard (web):
  - Open your browser and go to your installed location, eg. ```https://example.com/jirafeau/```
  - The script will redirect to you to a minimal installation wizard to set up all required options
  - All optional parameters may be set in ```lib/config.local.php```, take a look at ```lib/config.original.php``` to see all default values
- B) Setup without the installation wizard (cli):
  - Just copy ```lib/config.original.php``` to ```lib/config.local.php``` and customize it

💡 Hint: How to
[install & configure Jirafeau](https://www.howtoforge.com/how-to-setup-a-file-sharing-website-with-jirafeau-on-debian-10/)
on Debian 10 from scratch, with Nginx and PHP-FPM.

### Troubleshooting

If you have some troubles, consider the following cases

- Check your ```/lib/config.local.php``` file and compare it with ```/lib/config.original.php```, the configuration syntax or a parameter may have changed
- Check owner & permissions of your files
- set `debug` option to `true` to check any warning or error

## Security

```var``` directory contains all files and links. It is randomly named to limit access but you may add better protection to prevent un-authorized access to it.
You have several options:
- Configure a ```.htaccess```
- Move var folder to a place on your server which can't be directly accessed
- Disable automatic listing on your web server config or place a index.html in var's sub-directory (this is a limited solution)

If you are using Apache, you can add the following line to your configuration to prevent people to access to your ```var``` folder:

```RedirectMatch 301 ^/var-.* http://my.service.jirafeau ```

If you are using nginx, you can add the following to your $vhost.conf:

```nginx
location ~ /var-.* {
    deny all;
    return 404;
}
```

If you are using lighttpd, you can deny access to ```var``` folder in your configuration:

```
$HTTP["url"] =~ "^/var-*" {
         url.access-deny = ("")
}
```

You should also remove un-necessessary write access once the installation is done (ex: configuration file).
An other obvious basic security is to let access users to the site by HTTPS (make sure `web_root` in you `config.local.php` is set with https).

## Server side encryption

Data encryption can be activated in options. This feature makes the server encrypt data and send the decryt key to the user (inside download URL).
The decrypt key is not stored on the server so if you loose an url, you won't be able to retrieve file content.
Encryption is configured to use AES256 in OFB mode.
In case of security troubles on the server, attacker won't be able to access files.

By activating this feature, you have to be aware of few things:
-  Data encryption has a cost (cpu) and it takes more time for downloads to complete once file sent.
-  During the download, the server will decrypt on the fly (and use resource).
-  This feature needs to have the mcrypt php module.
-  File de-duplication will stop to work (as we can't compare two encrypted files).
-  Be sure your server do not log client's requests.
-  Don't forget to enable https.

In a next step, encryption will be made by the client (in javascript), see issue #10.

## License

GNU Affero General Public License v3 (AGPL-3.0).

The GNU Affero General Public License can be found at https://www.gnu.org/licenses/agpl.html.

Please note: If you decide do make adaptions to the source code and run a service with these changes incorporated,
you are required to provide a link to the source code of your version in order to obey the AGPL-3.0 license.
To do so please add a link to the source (eg. a public Git repository or a download link) to the Terms of Service page.
Take a look at the FAQ to find out about how to change the ToS.

PS: If you have fixed errors or added features, then please contribute to the project and send a merge request with these changes.

## Contribution

If you want to contribute to project, then take a look at the git repository:

- https://gitlab.com/mojo42/Jirafeau

and the Contribution Guidelines

- https://gitlab.com/mojo42/Jirafeau/blob/master/CONTRIBUTING.md

## FAQ

### Can I add a new language in Jirafeau?

Of course ! Translations are easy to make and no technical knowledge is required.

Simply go to [Jirafeau's Weblate](https://hosted.weblate.org/engage/jirafeau/).

If you want to add a new language in the list, feel free to contact us or leave a comment in ticket #9.

Thanks to all contributors ! :)

### How do I upgrade my Jirafeau?

See change log and upgrade procedure in [CHANGELOG.md](https://gitlab.com/mojo42/Jirafeau/blob/master/CHANGELOG.md).

### How can I limit upload access?

There are two ways to limit upload access (but not download):
- you can set one or more passwords in order to access the upload interface, or/and
- you can configure a list of authorized IP ([CIDR notation](https://en.wikipedia.org/wiki/Classless_Inter-Domain_Routing#CIDR_notation)) which are allowed to access to the upload page

Check documentation of ```upload_password``` and ```upload_ip``` parameters in [lib/config.original.php](https://gitlab.com/mojo42/Jirafeau/blob/master/lib/config.original.php).

### How can I automatize the cleaning of old (expired) files?

You can call the admin.php script from the command line (CLI) with the ```clean_expired``` or ```clean_async``` commands: ```sudo -u www-data php admin.php clean_expired```.

Then the command can be placed in a cron file to automatize the process. For example:
```
# m h dom mon dow user  command
12 3    * * *   www-data  php /path/to/jirafeau/admin.php clean_expired
16 3    * * *   www-data  php /path/to/jirafeau/admin.php clean_async
```

### I have some troubles with IE

If you have some strange behavior with IE, you may configure [compatibility mode](http://feedback.dominknow.com/knowledgebase/articles/159097-internet-explorer-ie8-ie9-ie10-and-ie11-compat).

Anyway I would recommend you to use another web browser. :)

### How can I change the theme?

You may change the default theme to any of the existing ones or a custom.

Open your ```lib/config.local.php``` and change setting in the »`style`« key to the name of any folder in the ```/media``` directory.

Hint: To create a custom theme just copy the »courgette« folder and name your theme »custom« (this way it will be ignored by git and not overwritten during updates). You are invited to enhance the existing themes and send pull requests however.

### I found a bug, what should I do?

Feel free to open a bug in the [GitLab's issues](https://gitlab.com/mojo42/Jirafeau/issues).

### How to set maximum file size?

If your browser supports HTML5 file API, you can send files as big as you want.

For browsers who does not support HTML5 file API, the limitation come from PHP configuration.
You have to set [post_max_size](https://php.net/manual/en/ini.core.php#ini.post-max-size) and [upload_max_filesize](https://php.net/manual/en/ini.core.php#ini.upload-max-filesize) in your php configuration. Note that Nginx setups may requiere to configure `client_max_body_size`.

If you don't want to allow unlimited upload size, you can still setup a maximal file size in Jirafeau's setting (see ```maximal_upload_size``` in your configuration)

### How can I edit an option?

Documentation of all default options are located in [lib/config.original.php](https://gitlab.com/mojo42/Jirafeau/blob/master/lib/config.original.php).
If you want to change an option, just edit your ```lib/config.local.php```.

### How can I change the Terms of Service?

The license text on the "Terms of Service" page, which is shipped with the default installation, is based on the »[Open Source Initiative Terms of Service](https://opensource.org/ToS)«.

To change this text simply copy the file [/lib/tos.original.txt](https://gitlab.com/mojo42/Jirafeau/blob/master/lib/tos.original.txt), rename it to ```/lib/tos.local.txt``` and adapt it to your own needs.

If you update the installation, then only the ```tos.original.txt``` file may change eventually, not your ```tos.local.txt``` file.

### How can I access the admin interface?

Just go to ```/admin.php```.

### How can I use the scripting interface (API)?

Simply go to ```/script.php``` with your web browser.

### My downloads are incomplete or my uploads fails

Be sure your PHP installation is not using safe mode, it may cause timeouts.

If you're using nginx, you might need to increase `client_max_body_size` or remove the restriction altogether. In your nginx.conf:

```nginx
http {
    # disable max upload size
    client_max_body_size 0;
    # add timeouts for very large uploads
    client_header_timeout 30m;
    client_body_timeout 30m;
}
```

### How can I monitor the use of my Jirafeau instance?

You may use Munin and simple scripts to collect the number of files in the Jirafeau instance as well as the disk space occupied by all the files. You can consult this [web page](https://blog.bandinelli.net/index.php?post/2016/05/15/Scripts-Munin-pour-Jirafeau).

### Why forking?

The original project seems not to be continued anymore and I prefer to add more features and increase security from a stable version.

### What can we expect in the future?

Check [issues](https://gitlab.com/mojo42/Jirafeau/issues) to check open bugs and incoming new stuff. :)

### What about this file deduplication thing?

Jirafeau uses a very simple file level deduplication for storage optimization.

This mean that if some people upload several times the same file, this will only store one time the file and increment a counter.

If someone use his/her delete link or an admin cleans expired links, this will decrement the counter corresponding to the file.

When the counter falls to zero, the file is destroyed.

In order to know if a newly uploaded file already exist, Jirafeau will hash the file using md5 by default but other methods are available (see `file_hash` documentation in `lib/config.original.php`).

### What is the difference between "delete link" and "delete file and links" in admin interface?

As explained in the previous question, files with the same hash are not duplicated and a reference counter stores the number of links pointing to a single file.
So:
- The button "delete link" will delete the reference to the file but might not destroy the file.
- The button "delete file and links" will delete all references pointing to the file and will destroy the file.

### How to contact someone from Jirafeau?

Feel free to create an issue if you found a bug.

### Can I buy you a coffee?

You can [drop few bucks](https://www.paypal.com/paypalme/jeromejutteau) to help the [demo web site](https://jirafeau.net) to stay alive.
