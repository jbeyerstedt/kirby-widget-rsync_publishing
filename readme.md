# kirby panel widget rsync publishing  
by Jannik Beyerstedt from Hamburg, Germany  
[jannikbeyerstedt.de](http://jannikbeyerstedt.de) | [Github](https://github.com/jbeyerstedt)  


## publish your content from staging to live site with just one click

In kirby CMS it´s not possible to preview content changes, so you need a staging server (kirby installation), when you will or can not edit the content only on your localhost.  
For copying the staging content to the live site, you could use shell scripts, FTP, or something more complicated. But with this panel widget syncing is only one button to click in the kirby panel.

## requirements:
- latest version of kirby, toolkit and panel. This widget was created with kirby v2.2.3.
- linux server with `rsync`
- php, which is allowed to execute shell commands by `shell_exec`
- both, staging and production site MUST BE ON THE SAME SERVER!!! (in this version)

## how to use
This widget uses `rsync` in the unix bash, so `rsync` must be availible and the php command `shell_exec` must not be blocked.  
To work proberly, the root folders of the staging and production site must be in the same directory. So the folder structure is like this:

```
+-- public_site/
|   +-- content/
|   +-- [...]
+-- staging_of_public_site/
|   +-- content/
|   +-- [...]
```

### Installation
To install this widet, store this all these files in

```
site/widgets/rsync_publishing/
```

Or add this repository as a submodule, but keep in mind to set the foldername to exactly `rsync_publishing`. Run this line, if you are in the root directory of your kirby installation.

```
git submodule add https://github.com/jbeyerstedt/kirby-widget-rsync_publishing ./site/widgets/rsync_publishing
```

Currently the use of this widget is limited to users with the role `admin`.

### options to set
To configure this widget, these options must be set in the `site/config/config.php` file:

```
// url of public site, just for a shortlink
c::set('rsync_publishing.publicSite_url', 'http://yourPublicSite.url');
// public site foldername, must be at same level as staging site
c::set('rsync_publishing.publicSite_folder', 'public_site');
// set your own rsync parameters. Will override all default parameters
c::set('rsync_publishing.rsyncOptions','-rlptz -u -v --delete');
```

### usage
This widget displays the shell command, which will be executed first. With the first click on "preview changes", `rsync` performs a dry run first. After that, the changes will be copied with  the button "publish changes".


## contribution
Feel free to fork this repository an make it better.
