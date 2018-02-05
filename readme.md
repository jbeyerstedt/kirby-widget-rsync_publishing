# Kirby Rsync Publishing Panel Widget
by Jannik Beyerstedt from Hamburg, Germany  
[jannikbeyerstedt.de](http://jannikbeyerstedt.de) | [Github](https://github.com/jbeyerstedt)  
**license:** GNU GPL v3  
**version:** 1.0.0

## Introduction
**Kirby Widget to publish your content from staging to live site via rsync**

In kirby CMS it’s not possible to preview content changes, so you need a staging server (kirby installation), when you will or can not edit the content only on your localhost.  
For copying the staging content to the live site, you could use shell scripts, FTP, or something more complicated. But with this panel widget syncing is only one button to click in the kirby panel.

## User Manual

### Requirements:
- latest version of kirby, toolkit and panel. This widget was created with kirby v2.2.3.
- linux server with `rsync`
- php, which is allowed to execute shell commands by `shell_exec`
- both, staging and production site **must be on the same server** (in this version)

### How to Use
This widget uses `rsync` in the unix bash, so `rsync` must be available and the php command `shell_exec` must not be blocked.  
To work properly, the root folders of the staging and production site must be in the same directory. So the folder structure is like this:

```
+-- public_site/
|   +-- content/
|   +-- [...]
+-- staging_of_public_site/
|   +-- content/
|   +-- [...]
+-- secondary_preview_site/
|   +-- content/
|   +-- [...]
```

The `secondary_preview_site` is optional. Some users have a staging site for development, a preview (secondary) site for review and the live site. So this use case will be covered as well.

#### Installation
To install this widget, store this all these files in

```
site/widgets/rsync_publishing/
```

Or add this repository as a submodule, but keep in mind to set the folder name to exactly `rsync_publishing`. Run this line, if you are in the root directory of your kirby installation.

```
git submodule add https://github.com/jbeyerstedt/kirby-widget-rsync_publishing ./site/widgets/rsync_publishing
```

Currently the use of this widget is limited to users with the role `admin`.

#### Options to Set
To configure this widget, these options must be set in the `site/config/config.php` file:

```
// url of public site, just for a shortlink
c::set('rsync_publishing.publicSite_url', 'http://yourPublicSite.url');
// public site folder name, must be at same level as staging site
c::set('rsync_publishing.publicSite_folder', 'public_site');
// set your own rsync parameters. Will override all default parameters
c::set('rsync_publishing.rsyncOptions','-rlptz -u -v --delete');

// optionally enable another sync location
c::set('rsync_publishing.secondarySite_enable', true);
c::set('rsync_publishing.secondarySite_url', 'http://preview.your.url');
c::set('rsync_publishing.secondarySite_folder', 'secondary_preview_site');

```

#### Usage
This widget displays the shell command, which will be executed first. With the first click on "preview changes", `rsync` performs a dry run first. After that, the changes will be copied with  the button "publish changes".


## Contribution
Feel free to fork this repository and make it better.
